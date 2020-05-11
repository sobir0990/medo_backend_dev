<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%resume}}`.
 */
class m190118_032229_create_resume_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%resume}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'files' => $this->string(255),
            'salary' => $this->integer(),
            'salary_to' => $this->integer(),
            'phone' => $this->string(18),
            'experience' => $this->string(255),
            'salary_type' => $this->tinyInteger(),
            'type' => $this->tinyInteger(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
        $this->createIndex('ind-resume-profile_id','resume','id');
        $this->addForeignKey('fk-resume-profile_id-profile-id','resume','profile_id','profile','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('ind-resume-profile_id','resume','id');
        $this->dropForeignKey('fk-resume-profile_id-profile-id','resume');
        $this->dropTable('{{%resume}}');
    }
}
