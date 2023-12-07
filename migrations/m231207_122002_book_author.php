<?php

use yii\db\Migration;

/**
 * Class m231207_122002_book_author
 */
class m231207_122002_book_author extends Migration
{
    private string $table = '{{%book_author}}';
    private string $tableBook = '{{%book}}';
    private string $tableAuthor = '{{%author}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->table, [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('PK_BookAuthor', $this->table, ['book_id', 'author_id']);

        $this->addForeignKey('FK_BookAuthor_BookId__Book_Id', $this->table, ['book_id'], $this->tableBook, ['id'], 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_BookAuthor_AuthorId__Author_Id', $this->table, ['author_id'], $this->tableAuthor, ['id'], 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('FK_BookAuthor_AuthorId__Author_Id', $this->table);
        $this->dropForeignKey('FK_BookAuthor_BookId__Book_Id', $this->table);

        $this->dropPrimaryKey('PK_BookAuthor', $this->table);

        $this->dropTable($this->table);
    }
}