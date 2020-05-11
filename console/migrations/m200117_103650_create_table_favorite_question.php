<?php

use yii\db\Migration;

/**
 * Class m200117_103650_create_table_favorite_question
 */
class m200117_103650_create_table_favorite_question extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('favorite_question', [
           'id' => $this->primaryKey(),
           'user_id' => $this->integer(),
           'question_id' => $this->integer(),
           'correct' => $this->integer(),
           'answer_id' => $this->integer(),
           'created_at' => $this->integer(),
           'updated_at' => $this->integer(),
        ]);

        $this->createIndex('idx_favorite_question__user_id', 'favorite_question', 'user_id');
        $this->createIndex('idx_favorite_question__question_id', 'favorite_question', 'question_id');

        $this->addForeignKey('fk-user_id-favorite_question',
            'favorite_question',
            'user_id',
            'user',
            'id');


        $this->addForeignKey('fk-question_id-favorite_question',
            'favorite_question',
            'question_id',
            'test_question',
            'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_favorite_question__user_id', 'favorite_question');
        $this->dropIndex('idx_favorite_question__question_id', 'favorite_question');
        $this->dropTable('favorite_question');
    }


}
