<?php

use yii\db\Migration;

class m190219_081330_create_encyclopedia_related_tables extends Migration
{
	public function safeUp()
	{
        $this->createTable('encyclopedia_reviewers', [
			'encyclopedia_id' => $this->integer(),
			'reviewer_id' => $this->integer(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer()
		]);

		$this->addPrimaryKey(
			'pk_encyclopedia_reviewer',
			'encyclopedia_reviewers',
			['encyclopedia_id', 'reviewer_id']);
		$this->addForeignKey(
			'fk_encyclopedia-id',
			'encyclopedia_reviewers',
			'encyclopedia_id',
			'encyclopedia',
			'id',
			'CASCADE',
			'CASCADE');
		$this->addForeignKey(
			'fk_reviewer_id__profile-id',
			'encyclopedia_reviewers',
			'reviewer_id',
			'profile',
			'id',
			'CASCADE',
			'CASCADE');

		$this->createTable('encyclopedia_categories', [
			'encyclopedia_id' => $this->integer()->null(),
			'category_id' => $this->integer()->null(),
		]);

		$this->addPrimaryKey(
			'pk_encyclopedia_categories',
			'encyclopedia_categories',
			['encyclopedia_id','category_id']);
		$this->addForeignKey(
			'fk-encyclopedia_categories-encyclopedia_id',
			'encyclopedia_categories',
			'encyclopedia_id',
			'encyclopedia',
			'id',
			'CASCADE',
			'CASCADE');
		$this->addForeignKey(
			'fk-encyclopedia_categories-category_id',
			'encyclopedia_categories',
			'category_id',
			'categories',
			'id',
			'CASCADE',
			'CASCADE');
	}

	public function safeDown()
	{
		$this->dropForeignKey('fk-encyclopedia_categories-category_id','encyclopedia_categories');
		$this->dropForeignKey('fk-encyclopedia_categories-encyclopedia_id','encyclopedia_categories');

		$this->dropForeignKey('fk_encyclopedia-id','encyclopedia_reviewers');
		$this->dropForeignKey('fk_reviewer_id__profile-id','encyclopedia_reviewers');

		$this->dropTable('encyclopedia_reviewers');
		$this->dropTable('encyclopedia_categories');
	}
}