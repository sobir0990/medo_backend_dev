<?php

use yii\db\Migration;

/**
 * Handles the creation of table `values`.
 */
class m181016_061522_create_values_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%values}}', [
            '[[value_id]]' => $this->primaryKey(),
            '[[type]]' => $this->integer(),
            '[[value]]' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('values');
    }
}
