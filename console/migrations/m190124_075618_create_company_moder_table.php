<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_moder`.
 */
class m190124_075618_create_company_moder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
   
        $this->createTable('company_moder', [
            'id' => $this->primaryKey(),
            'company_id'=>$this->integer()->notNull(),
            'reason_id'=>$this->integer()->notNull(),
            'status'=>$this->integer(),
            'created'=>$this->integer()
        ]);
        $this->createIndex('idx-company_moder-id','company_moder','id');
        $this->createIndex('idx-company_moder-company_id','company_moder','company_id');
        $this->createIndex('idx-company_moder-reason_id','company_moder','reason_id');

        $this->addForeignKey(
            'fk-company_moder-company_id',
            'company_moder',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-company_moder-reason_id',
            'company_moder',
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
        $this->dropIndex('idx-company_moder-id','company_moder');
        $this->dropIndex('idx-company_moder-company_id','company_moder');
        $this->dropIndex('idx-company_moder-reason_id','company_moder');
        $this->dropForeignKey('fk-company_moder-company_id','company_moder');
        $this->dropForeignKey('fk-company_moder-reason_id','company_moder');
        $this->dropTable('company_moder');
    }
}
