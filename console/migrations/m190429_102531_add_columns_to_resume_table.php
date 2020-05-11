<?php

use yii\db\Migration;

/**
 * Handles adding birth to table `profile`.
 */
class m190429_102531_add_columns_to_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('resume', 'name', $this->string(255));
        $this->addColumn('resume', 'birthday', $this->string(32));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'name');
        $this->dropColumn('resume', 'birthday');
    }
}
