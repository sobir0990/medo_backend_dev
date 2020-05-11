<?php

use yii\db\Migration;

/**
 * Handles the creation of table `resume_categories`.
 */
class m190122_122619_create_resume_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('resume_categories', [
            'resume_id' => $this->integer(11)->null(),
            'category_id' => $this->integer(11)->null(),
        ]);
        $this->addPrimaryKey('pk_resume_id_category_id','resume_categories', ['resume_id','category_id']);
        $this->CreateIndex('ind_resume_categories_resume_id','resume_categories','resume_id');
        $this->CreateIndex('ind_resume_categories_category_id','resume_categories','category_id');

        $this->addForeignKey(
            'fk-resume_categories-resume_id',
            'resume_categories',
            'resume_id',
            'resume',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-resume_categories-category_id',
            'resume_categories',
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
        $this->dropIndex('ind_resume_categories_resume_id', 'resume_categories');
        $this->dropIndex('ind_resume_categories_category_id', 'resume_categories');
        $this->dropForeignKey('fk-resume_categories-resume_id', 'resume_categories');
        $this->dropForeignKey('fk-resume_categories-category_id', 'resume_categories');
        $this->dropTable('resume_categories');
    }
}
