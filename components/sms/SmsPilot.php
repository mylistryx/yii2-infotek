<?php

namespace app\components\sms;

use app\models\Author;
use app\models\AuthorSubscribe;
use app\models\Book;
use yii\base\Component;

class SmsPilot extends Component
{
    public ?string $apiKey = null;

    public function informSubscribers(Author $author, Book $book): void
    {
        $subscribers = AuthorSubscribe::findAll(['author_id' => $author->id]);

        foreach ($subscribers as $subscriber) {
            $message = "$author->fullName выпрустил новую книгу $book->title!";
            $this->send(trim($subscriber->phone, '+'), $message);
        }
    }

    /**
     * ToDo: Errors processing
     */
    public function send(string $phone, string $message): bool
    {
        file_get_contents("https://smspilot.ru/api.php?send=$message&to=$phone&apikey=$this->apiKey&format=v");
        return true;
    }
}