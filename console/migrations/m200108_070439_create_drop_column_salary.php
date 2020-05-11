<?php

use yii\db\Migration;

/**
 * Class m200108_070439_create_drop_column_salary
 */
class m200108_070439_create_drop_column_salary extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('vacation', 'salary');
        $this->dropColumn('vacation', 'salary_to');
        $this->dropColumn('resume', 'salary');

        $this->addColumn('vacation', 'salary', $this->bigInteger());
        $this->addColumn('vacation', 'salary_to', $this->bigInteger());
        $this->addColumn('resume', 'salary', $this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacation', 'salary');
        $this->dropColumn('vacation', 'salary_to');
        $this->dropColumn('resume', 'salary');
    }

}
