<?php

use yii\db\Migration;

/**
 */
class m190523_102731_create_test_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('test_answer', [
            'id' => $this->primaryKey(),
            'answer' => $this->text()->notNull(),
            'question_id' => $this->integer(),
            'correct' => $this->tinyInteger()->defaultValue(0),
            'status' => $this->tinyInteger()->defaultValue(1),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-test_answer-test_question-id',
            'test_answer',
            'question_id',
            'test_question',
            'id',
            'CASCADE','CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('test_answer');
    }
}
