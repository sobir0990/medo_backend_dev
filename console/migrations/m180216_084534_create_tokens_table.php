<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tokens`.
 */
class m180216_084534_create_tokens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%tokens}}', [
            '[[token_id]]' => $this->primaryKey()->unique(),
            '[[user_id]]' => $this->integer(),
            '[[token]]' => $this->string(128)->unique(),
            '[[type]]' => $this->integer(),
            '[[expire]]' => $this->integer(),
            '[[status]]' => $this->integer()
        ]);


        $this->createIndex(
            'idx-tokens-user-user-id',
            '{{%tokens}}',
            '[[user_id]]'
        );

        $this->addForeignKey(
            'fk-tokens-user-user-id',
            '{{%tokens}}',
            '[[user_id]]',
            '{{%user}}',
            '[[id]]',
            'CASCADE'
        );

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-tokens-user-user-id',
            '{{%tokens}}'
        );

        $this->dropIndex(
            'idx-tokens-user-user-id',
            '{{%tokens}}'
        );

        $this->dropTable('{{%tokens}}');

    }
}
