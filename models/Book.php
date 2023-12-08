<?php

namespace app\models;

use app\forms\ImageForm;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;

/**
 * @property integer $id
 * @property string $image [varchar(255)]
 * @property string $title [varchar(120)]
 * @property string $description [text]
 * @property string $year [year]
 * @property string $isbn [varchar(20)]
 * @property-read ActiveQuery|array|Author[] $authors
 * @property-read ActiveQuery|array|BookAuthor $bookAuthors
 * @property-read array $allAuthors
 * @property-read array $yearsRange
 */
class Book extends ActiveRecord
{
    public const TYPE = ImageForm::TYPE_BOOK_COVER;

    public array $selectedAuthors = [];

    public static function tableName(): string
    {
        return '{{%book}}';
    }

    public function rules(): array
    {
        return [
            [['title', 'description', 'year', 'isbn'], 'required'],
            ['year', 'string', 'length' => [4, 4]],
            ['year', 'in', 'range' => $this->yearsRange],
            [['title'], 'string', 'length' => [3, 120]],
            [['description'], 'string'],
            ['isbn', 'normalizeAndValidateISBN'],
            ['selectedAuthors', 'required'],
            ['selectedAuthors', 'each', 'rule' => ['integer']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'isbn' => 'ISBN',
        ];
    }

    public function afterFind(): void
    {
        parent::afterFind();
        /** @var Author $model */
        $this->selectedAuthors = BookAuthor::find()->select('author_id')->where(['book_id' => $this->id])->column();
    }

    /**
     * @throws Exception
     * @throws StaleObjectException
     */
    public function afterSave($insert, $changedAttributes): void
    {
        $exists = ArrayHelper::map($this->bookAuthors, 'author_id', 'author_id');

        $removeAuthors = array_diff($exists, $this->selectedAuthors);

        $newAuthors = array_diff($this->selectedAuthors, $exists);

        foreach (Author::findAll(['id' => $removeAuthors]) as $author) {
            $this->unlink('authors', $author, true);
        }

        foreach (Author::findAll(['id' => $newAuthors]) as $author) {
            $this->link('authors', $author);
            Yii::$app->sms->informSubscribers($author, $this);
        }


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

    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->via('bookAuthors');
    }

    public function getBookAuthors(): ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getYearsRange(): array
    {
        static $range = [];
        if (empty($range)) {
            foreach (range(date('Y') + 10, 1500) as $item) {
                $range[$item] = $item;
            }
        }

        return $range;
    }

    public function getAllAuthors(): array
    {
        /** @var Author $model */
        return ArrayHelper::map(Author::find()->all(), 'id', 'fullName');
    }
}