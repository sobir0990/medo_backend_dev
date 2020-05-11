<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m150117_070926_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(64),
            'email' =>  $this->string(255),
            'phone'=> $this->string(18)->unique(),
            'auth_key'=> $this->string()->unique(),
            'password_hash' => $this->string(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'role' => $this->tinyInteger()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx_email','{{%user}}', 'email');

        $user = new \common\models\User();
        $user->load(array(
            'username'=>  'admin',
            'email' => 'admin',
            'password_hash' => Yii::$app->security->generatePasswordHash('1234567'),
            'auth_key'  => Yii::$app->security->generateRandomString(),
            'phone' => '123',
            'status' => '10',
            'role' => '10',
        ),'');
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
