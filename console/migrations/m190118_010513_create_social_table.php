<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%social}}`.
 */
class m190118_010513_create_social_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%social}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32),
            'link' => $this->string(255),
            'company_id' => $this->integer()
        ]);

        $this->createIndex('idn-social-company_id','social','company_id');
        $this->addForeignKey(
            'fk-social-social-company_id',
            'social',
            'company_id',
            'company',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idn-social-company_id','social');
        $this->dropForeignKey( 'fk-social-social-company_id','social');
        $this->dropTable('{{%social}}');
    }
}
