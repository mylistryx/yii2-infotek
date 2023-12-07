<?php

use yii\db\Migration;

/**
 * Class m231207_121947_book
 */
class m231207_121947_book extends Migration
{
    private string $table = '{{%book}}';

    private string $tableImage = '{{%image}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'image' => $this->string()->null(),
            'title' => $this->string(120)->notNull(),
            'description' => $this->text()->null(),
            'year' => $this->string(4)->notNull(),
            'isbn' => $this->string(20)->notNull(),
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
