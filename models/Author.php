<?php

namespace app\models;

use app\forms\ImageForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int|string $id
 * @property string $name
 * @property string $surname
 * @property null|string $patronymic
 * @property null|string $image
 * @property-read ActiveQuery $bookAuthors
 * @property-read ActiveQuery|array|AuthorSubscribe[] $subscribers
 * @property-read ActiveQuery|array|Book[] $books
 * @property-read string $fullName
 */
class Author extends ActiveRecord
{
    public const TYPE = ImageForm::TYPE_AUTHOR_PHOTO;

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
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }

    public function getSubscribers(): ActiveQuery
    {
        return $this->hasMany(AuthorSubscribe::class, ['author_id' => 'id']);
    }

    public function getFullName(): string
    {
        return trim(implode(' ', [$this->surname, $this->name, $this->patronymic]));
    }
}