<?php

use yii\db\Migration;

/**
 * Handles the creation of table `company_categories`.
 */
class m190122_122527_create_company_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('company_categories', [
            'company_id' => $this->integer(11)->null(),
            'category_id' => $this->integer(11)->null(),
        ]);

        $this->addPrimaryKey('pk_company_id_category_id','company_categories', ['company_id','category_id']);
        $this->CreateIndex('ind_company_categories_company_id','company_categories','company_id');
        $this->CreateIndex('ind_company_categories_category_id','company_categories','category_id');

        $this->addForeignKey(
            'fk-company_categories-company_id',
            'company_categories',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-company_categories-category_id',
            'company_categories',
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
        $this->dropIndex('ind_company_categories_company_id', 'company_categories');
        $this->dropIndex('ind_company_categories_category_id', 'company_categories');
        $this->dropForeignKey('fk-company_categories-company_id', 'company_categories');
        $this->dropForeignKey('fk-company_categories-category_id', 'company_categories');
        $this->dropTable('company_categories');
    }
}
