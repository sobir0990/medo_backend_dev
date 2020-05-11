<?php

use yii\db\Migration;

/**
 */
class m190609_102631_change_chat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('chat', 'type', $this->string(32));
        $this->addColumn('chat', 'ext_id', $this->integer());
        $this->addColumn('chat', 'user_1', $this->integer());
        $this->addColumn('chat', 'user_2', $this->integer());
        $this->addColumn('message', 'is_read', $this->tinyInteger()->defaultValue(0));
        $this->alterColumn('message', 'message', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown():bool
    {
        echo "can't revert!"; return false;
    }
}
