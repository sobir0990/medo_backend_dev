<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vacation_moder`.
 */
class m190124_080615_create_vacation_moder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
 
        $this->createTable('vacation_moder', [
            'id' => $this->primaryKey(),
            'vacation_id'=>$this->integer()->notNull(),
            'reason_id'=>$this->integer()->notNull(),
            'status'=>$this->integer(),
            'created'=>$this->integer()
        ]);
        $this->createIndex('idx-vacation_moder-id','vacation_moder','id');
        $this->createIndex('idx-vacation_moder-vacation_id','vacation_moder','vacation_id');
        $this->createIndex('idx-vacation_moder-reason_id','vacation_moder','reason_id');

        $this->addForeignKey(
            'fk-vacation_moder-vacation_id',
            'vacation_moder',
            'vacation_id',
            'vacation',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-vacation_moder-reason_id',
            'vacation_moder',
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
        $this->dropIndex('idx-vacation_moder-id','vacation_moder');
        $this->dropIndex('idx-vacation_moder-vacation_id','vacation_moder');
        $this->dropIndex('idx-vacation_moder-reason_id','vacation_moder');
        $this->dropForeignKey('fk-vacation_moder-vacation_id','vacation_moder');
        $this->dropForeignKey('fk-vacation_moder-reason_id','vacation_moder');
        $this->dropTable('vacation_moder');
    
    }
}
