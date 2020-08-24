<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%token}}`.
 */
class m200822_191143_create_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $this->createTable('{{%token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('юзер'),
            'token' => $this->string()->notNull()->comment('токен'),
            'expired_at' => $this->integer()->notNull()->comment('время истечения'),
        ]);

        $this->createIndex(
            'idx-token-user_id',
            '{{%token}}',
            'user_id');

        $this->addForeignKey(
            'fx_token_user',
            'token',
            'user_id',
            'user',
            'id',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%token}}');
    }
}
