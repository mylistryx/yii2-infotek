<?php

use yii\db\Migration;

/**
 * Class m231207_154323_author_subscribe
 */
class m231207_154323_author_subscribe extends Migration
{
    private string $table = '{{%author_subscribe}}';
    private string $tableAuthor = '{{%author}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(10)->notNull(),
            'created_at' => $this->dateTime(),
        ]);

        $this->addForeignKey('FK_AuthorSubscribe_AuthorId__Author_Id', $this->table, ['author_id'], $this->tableAuthor, 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('FK_AuthorSubscribe_AuthorId__Author_Id', $this->table);

        $this->dropTable($this->table);
    }
}
