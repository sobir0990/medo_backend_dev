<?php

use yii\db\Migration;

/**
 * Handles the creation of tables `chat` and `chat_user`.
 */
class m190227_050458_create_chat_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('chat', [
			'id' => $this->primaryKey(),
			'name' => $this->string(128),
			'company_id' => $this->integer(),
		]);
		$this->createIndex('idx-company_id', 'chat', 'company_id');
		$this->addForeignKey(
			'fk-chat-company_id',
			'chat',
			'company_id',
			'company',
			'id',
			'CASCADE',
			'CASCADE'
		);
		$this->renameColumn('message', 'reply_to', 'chat_id');
		$this->addForeignKey(
			'fk-message-chat_id-chat-id',
			'message',
			'chat_id',
			'chat',
			'id',
			'CASCADE',
			'CASCADE'
			);

		$this->createTable('chat_user', [
			'chat_id' => $this->integer(),
			'user_id' => $this->integer(),
		]);
		$this->addPrimaryKey('pk-chat_user','chat_user', ['chat_id', 'user_id']);
		$this->addForeignKey(
			'fk-chat_user-chat_id',
			'chat_user',
			'chat_id',
			'chat',
			'id',
			'CASCADE',
			'CASCADE'
		);
		$this->addForeignKey(
			'fk-chat_user-user_id',
			'chat_user',
			'user_id',
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
		$this->dropForeignKey('fk-chat_user-chat_id','chat_user');
		$this->dropForeignKey('fk-chat_user-user_id','chat_user');
		$this->dropTable('chat_user');

		$this->dropForeignKey('fk-message-chat_id-chat-id','message');
		$this->renameColumn('message', 'chat_id', 'reply_to');
		$this->dropForeignKey('fk-chat-company_id','chat');
		$this->dropIndex('idx-company_id', 'chat');
		$this->dropTable('chat');
	}
}
