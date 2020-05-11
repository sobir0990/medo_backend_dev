<?php

use yii\db\Migration;

/**
 * Class m191128_121418_create_add_column
 */
class m191128_121418_create_add_column extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('company', 'region_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropColumn('company', 'region_id');
    }
}
