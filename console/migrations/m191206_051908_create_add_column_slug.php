<?php

use yii\db\Migration;

/**
 * Class m191206_051908_create_add_column_slug
 */
class m191206_051908_create_add_column_slug extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('category', 'slug', $this->string(254));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('category', 'slug');
    }

}
