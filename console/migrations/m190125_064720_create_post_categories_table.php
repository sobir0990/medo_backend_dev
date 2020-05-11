<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post_categories`.
 */
class m190125_064720_create_post_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post_categories', [
            'post_id' => $this->integer(11)->null(),
            'category_id' => $this->integer(11)->null(),
        ]);
        $this->addPrimaryKey('pk_post_id_category_id','post_categories', ['post_id','category_id']);
        $this->CreateIndex('ind_post_categories_post_id','post_categories','post_id');
        $this->CreateIndex('ind_post_categories_category_id','post_categories','category_id');

        $this->addForeignKey(
            'fk-post_categories-post_id',
            'post_categories',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-post_categories-category_id',
            'post_categories',
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
        $this->dropIndex('ind_post_categories_post_id', 'post_categories');
        $this->dropIndex('ind_post_categories_category_id', 'post_categories');
        $this->dropForeignKey('fk-post_categories-post_id', 'post_categories');
        $this->dropForeignKey('fk-post_categories-category_id', 'post_categories');
        $this->dropTable('post_categories');
    }
}
