<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string $phone
 * @property int $author_id
 * @property-read ActiveQuery|null|Author $author
 */
class AuthorSubscribe extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%author_subscribe}}';
    }

    public function behaviors(): array
    {
        return [
            'TimeStamp' => [
                'class' => TimestampBehavior::class,
                'value' => date('Y-m-d H:i:s'),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['author_id', 'phone'], 'required'],
            ['author_id', 'exist', 'targetClass' => Author::class, 'targetAttribute' => 'id'],
            ['phone', 'filterPhone'],
        ];
    }

    public function filterPhone(string $attribute): void
    {
        if (!$this->hasErrors()) {
            $this->$attribute = substr(preg_replace('/[^0-9]/', "", $this->$attribute), -10);
        }
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}