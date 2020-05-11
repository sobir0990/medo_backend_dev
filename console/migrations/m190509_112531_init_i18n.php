<?php

use yii\db\Migration;

class m190509_112531_init_i18n extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(),
            'message' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%messages}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_message_id_language', '{{%messages}}', ['id', 'language']);
        $this->addForeignKey('fk_message_source_message', '{{%messages}}', 'id', '{{%source_message}}', 'id', 'CASCADE',
            'RESTRICT');
        $this->createIndex('idx_source_message_category', '{{%source_message}}', 'category');
        $this->createIndex('idx_message_language', '{{%messages}}', 'language');
    }

    public function down()
    {
        $this->dropForeignKey('fk_message_source_message', '{{%messages}}');
        $this->dropTable('{{%messages}}');
        $this->dropTable('{{%source_message}}');
    }
}
