<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume_moder`.
 */
class m190124_080637_create_resume_moder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('resume_moder', [
            'id' => $this->primaryKey(),
            'resume_id'=>$this->integer()->notNull(),
            'reason_id'=>$this->integer()->notNull(),
            'status'=>$this->integer(),
            'created'=>$this->integer()
        ]);
        $this->createIndex('idx-resume_moder-id','resume_moder','id');
        $this->createIndex('idx-resume_moder-resume_id','resume_moder','resume_id');
        $this->createIndex('idx-resume_moder-reason_id','resume_moder','reason_id');

        $this->addForeignKey(
            'fk-resume_moder-resume_id',
            'resume_moder',
            'resume_id',
            'resume',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-resume_moder-reason_id',
            'resume_moder',
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
        $this->dropIndex('idx-resume_moder-id','resume_moder');
        $this->dropIndex('idx-resume_moder-resume_id','resume_moder');
        $this->dropIndex('idx-resume_moder-reason_id','resume_moder');
        $this->dropForeignKey('fk-resume_moder-resume_id','resume_moder');
        $this->dropForeignKey('fk-resume_moder-reason_id','resume_moder');
        $this->dropTable('resume_moder');
    }
}
