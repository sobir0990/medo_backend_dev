<?php

use yii\db\Migration;

/**
 * Class m200108_104011_create_add_column_type
 */
class m200108_104011_create_add_column_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'type', $this->string(254));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('category', 'type');

    }

}
