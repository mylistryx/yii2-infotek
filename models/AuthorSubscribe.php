<?php

namespace app\models;

use udokmeci\yii2PhoneValidator\PhoneValidator;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

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
            ],
        ];
    }

    public function rules(): array
    {
        return [
            [['author_id', 'phone'], 'required'],
            ['author_id', 'exists', 'targetClass' => Author::class, 'targetAttribute' => 'id'],
            [['phone'], PhoneValidator::class, 'country' => 'RU'],
            ['phone', 'filterPhone'],
        ];
    }

    public function filterPhone(string $attribute): void
    {
        if (!$this->hasErrors()) {
            $this->$attribute = substr(preg_replace('/[^0-9]/', "", $this->$attribute), -10);
        }
    }
}