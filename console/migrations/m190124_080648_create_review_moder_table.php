<?php

use yii\db\Migration;

/**
 * Handles the creation of table `review_moder`.
 */
class m190124_080648_create_review_moder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('review_moder', [
            'id' => $this->primaryKey(),
            'review_id'=>$this->integer()->notNull(),
            'reason_id'=>$this->integer()->notNull(),
            'status'=>$this->integer(),
            'created'=>$this->integer()
        ]);
        $this->createIndex('idx-review_moder-id','review_moder','id');
        $this->createIndex('idx-review_moder-review_id','review_moder','review_id');
        $this->createIndex('idx-review_moder-reason_id','review_moder','reason_id');

        $this->addForeignKey(
            'fk-review_moder-review_id',
            'review_moder',
            'review_id',
            'review',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-review_moder-reason_id',
            'review_moder',
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
        $this->dropIndex('idx-review_moder-id','review_moder');
        $this->dropIndex('idx-review_moder-review_id','review_moder');
        $this->dropIndex('idx-review_moder-reason_id','review_moder');
        $this->dropForeignKey('fk-review_moder-review_id','review_moder');
        $this->dropForeignKey('fk-review_moder-reason_id','review_moder');
        $this->dropTable('review_moder');
    }
}
