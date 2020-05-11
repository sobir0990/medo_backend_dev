<?php

use yii\db\Migration;

/**
 * Class m200109_125202_create_add_column_company
 */
class m200109_125202_create_add_column_company extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('review', 'company_id', $this->integer());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('review', 'company_id');

    }

}
