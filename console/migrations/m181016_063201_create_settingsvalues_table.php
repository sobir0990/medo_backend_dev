<?php

use yii\db\Migration;

/**
 * Handles the creation of table `settingvalues`.
 */
class m181016_063201_create_settingsvalues_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('settingsvalues', [
            'setting_id' => $this->integer(11),
            'value_id' => $this->integer(11),
            'sort' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('settingsvalues');
    }
}
