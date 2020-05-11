<?php

use yii\db\Migration;

/**
 * Handles the creation of table `encyclopedia`.
 */
class m190219_081315_create_encyclopedia_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('encyclopedia', [
			'id' => $this->primaryKey(),
			'author_id' => $this->integer(),
			'title' => $this->string(255),
			'slug' => $this->string(255),
			'description' => $this->string(255),
			'text' => $this->text(),
			'reference' => $this->text(),
			'lang' => $this->integer(),
			'lang_hash' => $this->string(255),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
			'type' => $this->tinyInteger(),
			'status' => $this->tinyInteger()->defaultValue(0),
			'files' => $this->string(255),
			'publish_time' => $this->integer(),
			'top' => $this->integer()->defaultValue(0),
			'view' => $this->integer()->defaultValue(0),
			'letter' => $this->string(8),
		]);

		$this->createIndex('idx_encyclopedia-author_id', 'encyclopedia', 'author_id');

		$this->addForeignKey(
			'fk_ency-author_id__profile-id',
			'encyclopedia',
			'author_id',
			'profile',
			'id',
			'CASCADE',
			'CASCADE');
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropForeignKey('fk_ency-author_id__profile-id', 'encyclopedia');
		$this->dropIndex('idx_encyclopedia-author_id', 'encyclopedia');
		$this->dropTable('encyclopedia');
	}
}
