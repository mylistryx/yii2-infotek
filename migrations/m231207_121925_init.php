<?php

use yii\db\Migration;

/**
 * Class m231207_121925_init
 */
class m231207_121925_init extends Migration
{
    private string $table = '{{%identity}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->table, [

            'id' => $this->primaryKey(),
            'email' => $this->string(64)->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull()->unique(),
            'token' => $this->string(40)->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }

}
