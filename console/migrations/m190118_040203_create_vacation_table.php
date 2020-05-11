<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vacation}}`.
 */
class m190118_040203_create_vacation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vacation}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer(),
            'company_id' => $this->integer(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'files' => $this->string(255),
            'salary' => $this->integer(),
            'salary_to' => $this->integer(),
            'phone' => $this->string(18),
            'experience' => $this->string(45),
            'salary_type' => $this->tinyInteger(),
            'type' =>  $this->tinyInteger(),
            'address' => $this->string(255),
            'status' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->createIndex('ind-vacation-profile_id','vacation','profile_id');
        $this->createIndex('ind-vacation-company_id','vacation','company_id');
        $this->addForeignKey('fk-vacation-profile_id','vacation','profile_id','profile','id');
        $this->addForeignKey('fk-vacation-company_id','vacation','company_id','company','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('ind-vacation-profile_id','vacation');
        $this->dropIndex('ind-vacation-company_id','vacation');
        $this->dropForeignKey('fk-vacation-profile_id','vacation');
        $this->dropForeignKey('fk-vacation-company_id','vacation');
        $this->dropTable('{{%vacation}}');
    }
}
