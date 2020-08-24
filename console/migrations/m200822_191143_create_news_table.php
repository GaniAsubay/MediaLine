<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m200822_191143_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'creator' => $this->integer(11)->notNull(),
            'isDeleted' => $this->boolean()->defaultValue(false),
            'createdAt'=> $this->dateTime(),
        ]);

        $this->addForeignKey(
            '{{%fk-news-creator}}',
            '{{%news}}',
            'creator',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
