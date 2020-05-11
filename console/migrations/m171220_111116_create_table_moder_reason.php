<?php

use yii\db\Migration;

/**
 * Class m171220_111116_create_table_moder_reason
 */
class m171220_111116_create_table_moder_reason extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%moder_reason}}', array(
            'id' => $this->primaryKey(),
            'title'=>$this->string()->notNull(),
            'message'=>$this->text()->notNull(),
            'created'=>$this->integer()
        ), $tableOptions);


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%moder_reason}}');
    }



}
