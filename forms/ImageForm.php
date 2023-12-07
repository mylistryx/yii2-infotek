<?php

namespace app\forms;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ImageForm extends Model
{
    public const TYPE_BOOK_COVER = 100;
    public const TYPE_AUTHOR_PHOTO = 200;

    public const TYPE_FOLDERS = [
        self::TYPE_BOOK_COVER => 'cover',
        self::TYPE_AUTHOR_PHOTO => 'photo',
    ];
    public const ALLOWED_EXTENSIONS = ['png', 'jpg'];
    public ?UploadedFile $imageFile = null;
    public ?int $type = null;

    private ?string $fileName = null;

    public function rules(): array
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => self::ALLOWED_EXTENSIONS],
            ['type', 'in', 'range' => array_keys(self::TYPE_FOLDERS)],
        ];
    }

    /**
     * @throws Exception
     */
    public function upload(): bool
    {
        if ($this->validate()) {
            $filename = $this->filename ?? md5(Yii::$app->security->generateRandomString() . time()) . '.' . $this->imageFile->extension;
            $storage = Yii::getAlias('@storage') . self::TYPE_FOLDERS[$this->type];
            $path = FileHelper::normalizePath($storage . DIRECTORY_SEPARATOR . $filename);
            $this->imageFile->saveAs($path);
            return true;
        } else {
            return false;
        }
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }
}