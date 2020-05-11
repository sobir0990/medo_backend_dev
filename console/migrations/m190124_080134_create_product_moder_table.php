<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_moder`.
 */
class m190124_080134_create_product_moder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
        $this->createTable('product_moder', [
            'id' => $this->primaryKey(),
            'product_id'=>$this->integer()->notNull(),
            'reason_id'=>$this->integer()->notNull(),
            'status'=>$this->integer(),
            'created'=>$this->integer()
        ]);
        $this->createIndex('idx-product_moder-id','product_moder','id');
        $this->createIndex('idx-product_moder-product_id','product_moder','product_id');
        $this->createIndex('idx-product_moder-reason_id','product_moder','reason_id');

        $this->addForeignKey(
            'fk-product_moder-product_id',
            'product_moder',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_moder-reason_id',
            'product_moder',
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
        $this->dropIndex('idx-product_moder-id','product_moder');
        $this->dropIndex('idx-product_moder-product_id','product_moder');
        $this->dropIndex('idx-product_moder-reason_id','product_moder');
        $this->dropForeignKey('fk-product_moder-product_id','product_moder');
        $this->dropForeignKey('fk-product_moder-reason_id','product_moder');
        $this->dropTable('product_moder');
    }
}
