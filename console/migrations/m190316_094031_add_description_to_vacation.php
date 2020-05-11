<?php

use yii\db\Migration;

/**
 * Class m190316_094031_add_description_to_vacation
 */
class m190316_094031_add_description_to_vacation extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('vacation', 'description', $this->text());
		$this->addColumn('resume', 'description', $this->text());
		$this->addColumn('resume', 'education', $this->integer());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('resume', 'description');
		$this->dropColumn('resume', 'education');
		$this->dropColumn('vacation', 'description');
	}
}
