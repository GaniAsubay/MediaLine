<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_catigories}}`.
 */
class m200822_191244_create_news_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_categories}}', [
            'id' => $this->primaryKey(),
            'newsID' => $this->integer(11)->notNull(),
            'categoryID' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-news_categories-newsID}}',
            '{{%news_categories}}',
            'newsID',
            '{{%news}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-news_categories-categoryID}}',
            '{{%news_categories}}',
            'categoryID',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_categories}}');
    }
}
