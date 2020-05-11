<?php

use yii\db\Migration;

/**
 * Class m200107_103432_create_add_column_tag
 */
class m200107_103432_create_add_column_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post', 'tags', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post', 'tags');
    }


}
