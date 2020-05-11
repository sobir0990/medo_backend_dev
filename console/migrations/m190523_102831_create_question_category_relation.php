<?php

use yii\db\Migration;

/**
 */
class m190523_102831_create_question_category_relation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('question_category', [
            'question_id' => $this->integer(),
            'category_id' => $this->integer()
        ]);
        $this->addPrimaryKey(
            'pk-question_category',
            'question_category',
            ['question_id', 'category_id']
        );
        $this->addForeignKey(
            'fk-question_category-test_question-id',
            'question_category',
            'question_id',
            'test_question',
            'id',
            'CASCADE','CASCADE'
        );
        $this->addForeignKey(
            'fk-question_category-categories-id',
            'question_category',
            'category_id',
            'categories',
            'id',
            'CASCADE','CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('question_category');
    }
}
