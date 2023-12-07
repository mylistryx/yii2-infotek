<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $book_id
 * @property int $author_id
 * @property-read ActiveQuery|Book|null $book
 * @property-read ActiveQuery|Author|null $author
 */
class BookAuthor extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%book_author}}';
    }

    public function rules(): array
    {
        return [
            [['book_id', 'author_id'], 'required'],
            [['book_id', 'author_id'], 'integer'],
            ['book_id', 'exists', 'targetClass' => Book::class, 'targetAttribute' => 'id'],
            ['author_id', 'exists', 'targetClass' => Author::class, 'targetAttribute' => 'id'],
            [['book_id', 'author_id'], 'unique'],
        ];
    }

    public function getBook(): ActiveQuery
    {
        $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}