<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%company}}`.
 */
class m190117_114305_create_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer(),
            'name' => $this->string(255),
            'type' => $this->tinyInteger(),
            'image' => $this->string(255),
            'status' => $this->tinyInteger()->defaultValue(0),
            'description' => $this->string(255),
            'phone' => $this->string(20),
            'address' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('ind-company-id','company','id');
        $this->createIndex('ind-company-profile_id','company', 'profile_id');

        $this->addForeignKey('fk-company-profile_id-profile-id',
            'company',
            'profile_id',
            'profile',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%company}}');
    }
}
