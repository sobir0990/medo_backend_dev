<?php

use yii\db\Migration;

/**
 * Handles adding reply_to to table `review`.
 */
class m190305_124530_add_reply_to_column_to_review_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('review', 'reply_to', $this->integer());
		$this->addForeignKey(
			'fk_review_reply_to-id',
			'review',
			'reply_to',
			'review',
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
		$this->dropForeignKey('fk_review_reply_to-id', 'review');
		$this->dropColumn('review', 'reply_to');
	}
}
