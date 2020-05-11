<?php

use yii\db\Migration;

/**
 * Class m191011_045032_alter_name_column_to_region_table
 */
class m191011_045032_alter_name_column_to_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('region', 'name', 'name_ru');
        $this->renameColumn('city', 'name', 'name_ru');
        $this->addColumn('region', 'name_uz', $this->string());
        $this->addColumn('city', 'name_uz', $this->string());

        $this->dropForeignKey('fk-product-product-company_id-company-id','product');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addForeignKey(
            'fk-product-product-company_id-company-id',
            'product',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );
        $this->renameColumn('region', 'name_ru', 'name');
        $this->renameColumn('city', 'name_ru', 'name');
        $this->dropColumn('region', 'name_uz');
        $this->dropColumn('city', 'name_uz');
    }

}
