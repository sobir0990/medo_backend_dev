<?php

use yii\db\Migration;

/**
 * Class m190309_060218_add_city_to_tables
 */
class m190309_060218_add_city_to_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//    	$this->addColumn('company', 'city_id', $this->integer());
//    	$this->addColumn('vacation', 'city_id', $this->integer());
//    	$this->addColumn('resume', 'city_id', $this->integer());
//    	$this->addColumn('product', 'city_id', $this->integer());

//    	$this->addForeignKey('fk_vacation_city-id', 'vacation', 'city_id', 'city', 'id', 'RESTRICT', 'CASCADE');
//    	$this->addForeignKey('fk_company_city-id', 'company', 'city_id', 'city', 'id', 'RESTRICT', 'CASCADE');
//    	$this->addForeignKey('fk_product_city-id', 'product', 'city_id', 'city', 'id', 'RESTRICT', 'CASCADE');
//    	$this->addForeignKey('fk_resume_city-id', 'resume', 'city_id', 'city', 'id', 'RESTRICT', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	$this->dropForeignKey('fk_vacation_city-id', 'vacation');
    	$this->dropForeignKey('fk_company_city-id', 'company');
    	$this->dropForeignKey('fk_product_city-id', 'product');
    	$this->dropForeignKey('fk_resume_city-id', 'resume');

    	$this->dropColumn('vacation', 'city_id');
    	$this->dropColumn('company', 'city_id');
    	$this->dropColumn('product', 'city_id');
    	$this->dropColumn('resume', 'city_id');
    }
}
