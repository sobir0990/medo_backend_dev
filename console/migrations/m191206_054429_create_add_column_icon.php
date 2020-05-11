<?php

use yii\db\Migration;

/**
 * Class m191206_054429_create_add_column_icon
 */
class m191206_054429_create_add_column_icon extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'icon', $this->string(254));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('category', 'icon');
    }


}
