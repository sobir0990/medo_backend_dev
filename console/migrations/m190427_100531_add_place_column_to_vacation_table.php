<?php

use yii\db\Migration;

/**
 * Handles adding birth to table `profile`.
 */
class m190427_100531_add_place_column_to_vacation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacation', 'place_id', $this->integer());
        $this->addColumn('resume', 'place_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('resume', 'place_id');
        $this->dropColumn('vacation', 'place_id');
    }
}
