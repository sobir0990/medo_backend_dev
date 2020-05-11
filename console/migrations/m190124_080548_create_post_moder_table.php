<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_moder`.
 */
class m190124_080548_create_post_moder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_moder', [
            'id' => $this->primaryKey(),
            'post_id'=>$this->integer()->notNull(),
            'reason_id'=>$this->integer()->notNull(),
            'status'=>$this->integer(),
            'created'=>$this->integer()
        ]);
        $this->createIndex('idx-post_moder-id','post_moder','id');
        $this->createIndex('idx-post_moder-post_id','post_moder','post_id');
        $this->createIndex('idx-post_moder-reason_id','post_moder','reason_id');

        $this->addForeignKey(
            'fk-post_moder-post_id',
            'post_moder',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-post_moder-reason_id',
            'post_moder',
            'reason_id',
            'moder_reason',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-post_moder-id','post_moder');
        $this->dropIndex('idx-post_moder-post_id','post_moder');
        $this->dropIndex('idx-post_moder-reason_id','post_moder');
        $this->dropForeignKey('fk-post_moder-post_id','post_moder');
        $this->dropForeignKey('fk-post_moder-reason_id','post_moder');
        $this->dropTable('post_moder');
    }
}
