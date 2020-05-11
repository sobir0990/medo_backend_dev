<?php

use yii\db\Migration;

/**
 * Class m200127_123025_add_column_profile
 */
class m200127_123025_add_column_profile extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->addColumn('profile', 'profession_id', $this->integer());
//        $this->addColumn('profile', 'bio', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('profile', 'profession_id');
        $this->dropColumn('profile', 'bio');
    }


}
