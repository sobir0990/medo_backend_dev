<?php

use yii\db\Migration;

/**
 * Class m200203_064233_add_column_lang
 */
class m200203_064233_add_column_lang extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('test_answer', 'lang', $this->integer());
        $this->addColumn('test_answer', 'lang_hash', $this->string(254));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('test_answer', 'lang');
        $this->dropColumn('test_answer', 'lang_hash');
    }


}
