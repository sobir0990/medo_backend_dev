<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m190118_021008_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer(11),
            'text' => $this->text(),
            'reply_to_id' => $this->integer(11),
            'status' => $this->tinyInteger()->defaultValue(0)
        ]);
        $this->createIndex('ind-comment-profile_id-profile-id', 'comment','profile_id');
        $this->createIndex('ind-comment-reply_to_id','comment','reply_to_id');

        $this->addForeignKey(
            'fk-comment-profile_id-profile-id',
            'comment',
            'profile_id',
            'profile',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comment-profile_id-comment-reply_to_id',
            'comment',
            'reply_to_id',
            'comment',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('ind-comment-profile_id-profile-id', 'comment');
        $this->dropIndex('ind-comment-reply_to_id','comment');
        $this->addForeignKey('fk-comment-profile_id-profile-id','comment');
        $this->addForeignKey('fk-comment-profile_id-comment-reply_to_id','comment');
        $this->dropTable('{{%comment}}');
    }
}
