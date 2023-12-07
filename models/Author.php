<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int|string $id
 * @property string $name
 * @property string $surname
 * @property null|string $patronymic
 * @property null|string $image
 * @property-read ActiveQuery $bookAuthors
 * @property-read ActiveQuery $books
 */
class Author extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%author}}';
    }

    public function rules(): array
    {
        return [
            [['name', 'surname'], 'required'],
            ['name', 'string', 'length' => [2, 30]],
            ['surname', 'string', 'length' => [2, 30]],
            ['patronymic', 'string', 'length' => [2, 30], 'skipOnEmpty' => true],
            ['image', 'string', 'skipOnEmpty' => true],
        ];
    }

    public function getBooks(): ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->via('bookAuthors');
    }

    public function getBookAuthors(): ActiveQuery
    {
        $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }
}