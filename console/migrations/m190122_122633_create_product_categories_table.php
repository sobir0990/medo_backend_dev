<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_categories`.
 */
class m190122_122633_create_product_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
 
        $this->createTable('product_categories', [
            'product_id' => $this->integer(11)->null(),
            'category_id' => $this->integer(11)->null(),
        ]);
        $this->addPrimaryKey('pk_product_id_category_id','product_categories', ['product_id','category_id']);
        $this->CreateIndex('ind_product_categories_product_id','product_categories','product_id');
        $this->CreateIndex('ind_product_categories_category_id','product_categories','category_id');

        $this->addForeignKey(
            'fk-product_categories-product_id',
            'product_categories',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-product_categories-category_id',
            'product_categories',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('ind_product_categories_product_id', 'product_categories');
        $this->dropIndex('ind_product_categories_category_id', 'product_categories');
        $this->dropForeignKey('fk-product_categories-product_id', 'product_categories');
        $this->dropForeignKey('fk-product_categories-category_id', 'product_categories');
        $this->dropTable('product_categories');
    }
}
