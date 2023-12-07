<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $token
 * @property-read string $authKey
 * @property-write string $password
 */
class Identity extends ActiveRecord implements IdentityInterface
{
    public function rules(): array
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],

            ['password_hash', 'required'],

            ['auth_key', 'default', 'value' => fn() => Yii::$app->security->generateRandomString(32)],
            ['auth_key', 'unique'],

            ['token', 'default', 'value' => fn() => Yii::$app->security->generateRandomString(40)],
            ['token', 'unique'],
        ];
    }

    public static function create(string $email, string $password): static
    {
        ($identity = new static([
            'email' => $email,
            'password' => $password,
        ]))->save();

        return $identity;
    }

    public static function findIdentityByEmail(string $email): ?static
    {
        return static::findOne(['email' => $email]);
    }

    public static function findIdentity($id): ?static
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?static
    {
        return static::findOne(['token' => $token]);
    }

    public function getId(): int|string
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
}
