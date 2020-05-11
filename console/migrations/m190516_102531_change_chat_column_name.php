<?php

use yii\db\Migration;

/**
 */
class m190516_102531_change_chat_column_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('chat', 'name', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('chat', 'title', 'name');
    }
}
