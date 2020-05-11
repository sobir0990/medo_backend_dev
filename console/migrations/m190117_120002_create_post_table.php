<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m190117_120002_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer(),
            'title' => $this->string(255),
            'slug' => $this->string(255),
            'description' => $this->string(255),
            'text' => $this->text(),
            'lang' => $this->integer(11),
            'lang_hash' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'type' => $this->tinyInteger(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'files' => $this->string(255),
            'company_id' => $this->integer(),
            'publish_time' => $this->integer(),
            'top' => $this->integer(11)->defaultValue(0),
            'view' => $this->integer(11)->defaultValue(0)
        ]);
        $this->createIndex(
            'ind-post-profile_id-profile-id',
            'post',
            'profile_id'
        );
        $this->createIndex(
            'ind-post-company_id-company-id',
            'post',
            'company_id'
        );

        $this->addForeignKey('fk-post-profile_id-profile-id','post','profile_id','profile','id','CASCADE');
        $this->addForeignKey('fk-post-company_id-company-id','post','company_id','company','id','CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropIndex('ind-post-profile_id-profile-id','post');
        $this->dropIndex('ind-post-company_id-company-id', 'post');
        $this->dropForeignKey('fk-post-profile_id-profile-id','post');
        $this->dropForeignKey('fk-post-company_id-company-id','post');
        $this->dropTable('{{%post}}');
    }
}
