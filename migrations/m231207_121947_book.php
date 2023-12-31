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
            'title' => $this->string(120)->notNull(),
            'description' => $this->text()->notNull(),
            'year' => 'YEAR NOT NULL',
            'isbn' => $this->string(20)->notNull(),
            'image' => $this->string()->null(),
        ]);

        $this->createIndex('IDX_Book_Year', $this->table, ['year']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropIndex('IDX_Book_Year', $this->table);
        $this->dropTable($this->table);
    }
}
