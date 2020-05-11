<?php

use yii\db\Migration;

/**
 * Handles the creation of table `vacation_categories`.
 */
class m190122_122555_create_vacation_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('vacation_categories', [
            'vacation_id' => $this->integer(11)->null(),
            'category_id' => $this->integer(11)->null(),
        ]);

        $this->addPrimaryKey('pk_vacation_id_category_id','vacation_categories', ['vacation_id','category_id']);
        $this->CreateIndex('ind_vacation_categories_vacation_id','vacation_categories','vacation_id');
        $this->CreateIndex('ind_vacation_categories_category_id','vacation_categories','category_id');

        $this->addForeignKey(
            'fk-vacation_categories-vacation_id',
            'vacation_categories',
            'vacation_id',
            'vacation',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-vacation_categories-category_id',
            'vacation_categories',
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
        $this->dropIndex('ind_vacation_categories_vacation_id', 'vacation_categories');
        $this->dropIndex('ind_vacation_categories_category_id', 'vacation_categories');
        $this->dropForeignKey('fk-vacation_categories-vacation_id', 'vacation_categories');
        $this->dropForeignKey('fk-vacation_categories-category_id', 'vacation_categories');
        $this->dropTable('vacation_categories');
    }
}
