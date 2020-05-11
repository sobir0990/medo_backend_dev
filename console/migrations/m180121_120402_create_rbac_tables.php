<?php

use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Class m190121_120402_create_rbac_tables
 */
class m180121_120402_create_rbac_tables extends Migration
{
	/**
	 * @throws yii\base\InvalidConfigException
	 * @return DbManager
	 */
	protected function getAuthManager()
	{
		$authManager = Yii::$app->getAuthManager();
		if (!$authManager instanceof DbManager) {
			throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
		}

		return $authManager;
	}

	/**
	 * @return bool|void
	 * @throws InvalidConfigException
	 * @throws \yii\base\NotSupportedException
	 */
	public function up()
	{
		$authManager = $this->getAuthManager();
		$this->db = $authManager->db;
		$schema = $this->db->getSchema()->defaultSchema;

		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}

		$this->createTable($authManager->ruleTable, [
			'name' => $this->string(64)->notNull(),
			'data' => $this->binary(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
			'PRIMARY KEY ([[name]])',
		], $tableOptions);

		$this->createTable($authManager->itemTable, [
			'name' => $this->string(64)->notNull(),
			'type' => $this->smallInteger()->notNull(),
			'description' => $this->text(),
			'rule_name' => $this->string(64),
			'data' => $this->binary(),
			'created_at' => $this->integer(),
			'updated_at' => $this->integer(),
			'PRIMARY KEY ([[name]])',
			'FOREIGN KEY ([[rule_name]]) REFERENCES ' . $authManager->ruleTable . ' ([[name]])' .
			$this->buildFkClause('ON DELETE SET NULL', 'ON UPDATE CASCADE'),
		], $tableOptions);

		$this->createTable($authManager->itemChildTable, [
			'parent' => $this->string(64)->notNull(),
			'child' => $this->string(64)->notNull(),
			'PRIMARY KEY ([[parent]], [[child]])',
			'FOREIGN KEY ([[parent]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
			$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
			'FOREIGN KEY ([[child]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
			$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
		], $tableOptions);

		$this->createTable($authManager->assignmentTable, [
			'item_name' => $this->string(64)->notNull(),
			'user_id' => $this->string(64)->notNull(),
			'created_at' => $this->integer(),
			'PRIMARY KEY ([[item_name]], [[user_id]])',
			'FOREIGN KEY ([[item_name]]) REFERENCES ' . $authManager->itemTable . ' ([[name]])' .
			$this->buildFkClause('ON DELETE CASCADE', 'ON UPDATE CASCADE'),
		], $tableOptions);

		$this->createIndex('{{%idx-auth_item-type}}', $authManager->itemTable, 'type');
		$this->createIndex('{{%idx-auth_assignment-user_id}}', $authManager->assignmentTable, 'user_id');


        $admin = $authManager->createRole('admin');
        $user = $authManager->createRole('user');
        $authManager->add($admin);
        $authManager->add($user);
        $authManager->addChild($admin, $user);
        $authManager->assign($admin, 1);
	}

	/**
	 * @return bool|void
	 * @throws InvalidConfigException
	 */
	public function down()
	{
		$authManager = $this->getAuthManager();
		$this->db = $authManager->db;

		$this->dropIndex('{{%idx-auth_assignment-user_id}}', $authManager->assignmentTable);
		$this->dropIndex('{{%idx-auth_item-type}}', $authManager->itemTable);

		$this->dropTable($authManager->assignmentTable);
		$this->dropTable($authManager->itemChildTable);
		$this->dropTable($authManager->itemTable);
		$this->dropTable($authManager->ruleTable);
	}

	protected function buildFkClause($delete = '', $update = '')
	{
		return implode(' ', ['', $delete, $update]);
	}
}
