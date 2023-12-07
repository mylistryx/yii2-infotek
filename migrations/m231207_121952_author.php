<?php

use yii\db\Migration;

/**
 * Class m231207_121952_author
 */
class m231207_121952_author extends Migration
{
    private string $table = '{{%author}}';
    private string $tableIdentity = '{{%identity}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'patronymic' => $this->string()->null(),
            'image' => $this->string()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable($this->table);
    }
}
