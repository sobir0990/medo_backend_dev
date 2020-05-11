<?php

use yii\db\Migration;

/**
 * Handles the creation of table `phone_confirmation`.
 */
class m181210_131351_create_phone_confirmation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('phone_confirmation', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(15),
            'code' => $this->string(20),
            'status' => $this->integer(2)->defaultValue(0),
            'created_at' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('phone_confirmation');
    }
}
