<?php

use yii\db\Migration;

/**
 */
class m190523_102631_create_test_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('test_question', [
            'id' => $this->primaryKey(),
            'question' => $this->text()->notNull(),
            'status' => $this->tinyInteger()->defaultValue(1),
            'lang' => $this->integer(),
            'lang_hash' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('test_question');
    }
}
