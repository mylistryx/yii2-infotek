<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $image [varchar(255)]
 * @property string $title [varchar(120)]
 * @property string $description [text]
 * @property string $year [year]
 * @property string $isbn [varchar(20)]
 */
class Book extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%book}}';
    }

    public function rules(): array
    {
        return [
            [['title', 'description', 'year', 'isbn'], 'required'],
            ['year', 'string', 'length' => [4, 4]],
            ['year', 'in', 'range' => range(1500, date('Y') + 1)],
            [['title'], 'string', 'length' => [3, 120]],
            [['description'], 'string'],
            ['isbn', 'normalizeAndValidateISBN'],
        ];
    }

    public function normalizeAndValidateISBN(string $attribute): void
    {
        if (!$this->hasErrors()) {
            $cleanIsbn = preg_replace('/[^0-9]/', "", $this->$attribute);
            /** ToDo: Check checkSum https://ru.wikipedia.org/wiki/Международный_стандартный_книжный_номер */
            $length = strlen($cleanIsbn);
            if ($length == 10) {
                /** 10 digits format 2-266-11156-6 */
                $this->$attribute =
                    substr($cleanIsbn, 0, 1) . '-' .
                    substr($cleanIsbn, 1, 3) . '-' .
                    substr($cleanIsbn, 4, 5) . '-' .
                    substr($cleanIsbn, 9, 1);
            } elseif ($length == 13) {
                /** 13 digits format 978-2-266-11156-0 */
                $this->$attribute =
                    substr($cleanIsbn, 0, 3) . '-' .
                    substr($cleanIsbn, 3, 1) . '-' .
                    substr($cleanIsbn, 4, 3) . '-' .
                    substr($cleanIsbn, 7, 5) . '-' .
                    substr($cleanIsbn, 12, 1);
            } else {
                $this->addError($attribute, 'Incorrect ISBN code!');
            }
        }
    }
}