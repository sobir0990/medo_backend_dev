<?php

use yii\db\Migration;

/**
 * Handles the creation of table `payment_history`.
 */
class m181214_030941_create_payment_history_table extends Migration
{

    const TABLE = '{{%payment_history}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'user_id' => $this->bigInteger(20),
            'payment_type' => $this->integer(3),
            'amount' => $this->bigInteger(14),
            'created_at' => $this->bigInteger(15)
        ]);

        $this->createIndex(
            'idx-payment_history-user_id',
            self::TABLE,
            'user_id'
        );

        $this->addForeignKey(
            'fk-payment_history-user_id-user-id',
            self::TABLE,
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropForeignKey(
            'fk-payment_history-user_id-user-id',
            self::TABLE
        );

        $this->dropIndex(
            'idx-payment_history-user_id',
            self::TABLE
        );

        $this->dropTable(self::TABLE);
    }
}
