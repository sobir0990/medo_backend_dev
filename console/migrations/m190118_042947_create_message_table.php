<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m190118_042947_create_message_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%message}}', [
			'id' => $this->primaryKey(),
			'message' => $this->string(255),
			'from_user' => $this->integer(),
			'reply_to' => $this->integer(),
			'status' => $this->integer(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
		]);

		$this->createIndex('ind-message-from', 'message', 'from_user');
		$this->createIndex('ind-message-from_to', 'message', 'reply_to');

		$this->addForeignKey(
			'fk-message-from-profile-id',
			'message',
			'from_user',
			'profile',
			'id',
			'CASCADE',
			'CASCADE'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{

		$this->dropTable('{{%message}}');
	}
}
