<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile_categories`.
 */
class m190122_122459_create_profile_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('profile_categories', [
            'profile_id' => $this->integer(11)->null(),
            'category_id' => $this->integer(11)->null(),
        ]);

        $this->addPrimaryKey('pk_profile_id_category_id','profile_categories', ['profile_id','category_id']);
        $this->CreateIndex('ind_profile_categories_profile_id','profile_categories','profile_id');
        $this->CreateIndex('ind_profile_categories_category_id','profile_categories','category_id');

        $this->addForeignKey(
            'fk-profile_categories-profile_id',
            'profile_categories',
            'profile_id',
            'profile',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-profile_categories-category_id',
            'profile_categories',
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
        $this->dropIndex('ind_profile_categories_profile_id', 'profile_categories');
        $this->dropIndex('ind_profile_categories_category_id', 'profile_categories');
        $this->dropForeignKey('fk-profile_categories-profile_id', 'profile_categories');
        $this->dropForeignKey('fk-profile_categories-category_id', 'profile_categories');
        $this->dropTable('profile_categories');
    }
}
