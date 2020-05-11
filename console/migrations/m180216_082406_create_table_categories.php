<?php

use yii\db\Migration;

class m180216_082406_create_table_categories extends Migration
{
	const TABLE_NAME = '{{%categories}}';

	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}
		$this->createTable(self::TABLE_NAME, [
			'[[id]]' => $this->primaryKey(),
			'[[root]]' => $this->integer(),
			'[[lft]]' => $this->integer()->notNull(),
			'[[rgt]]' => $this->integer()->notNull(),
			'[[lvl]]' => $this->smallInteger(5)->notNull(),
			'[[active]]' => $this->boolean()->notNull()->defaultValue(true),
			'[[selected]]' => $this->boolean()->notNull()->defaultValue(false),
			'[[disabled]]' => $this->boolean()->notNull()->defaultValue(false),
			'[[readonly]]' => $this->boolean()->notNull()->defaultValue(false),
			'[[visible]]' => $this->boolean()->notNull()->defaultValue(true),
			'[[collapsed]]' => $this->boolean()->notNull()->defaultValue(false),
			'[[movable_u]]' => $this->boolean()->notNull()->defaultValue(true),
			'[[movable_d]]' => $this->boolean()->notNull()->defaultValue(true),
			'[[movable_l]]' => $this->boolean()->notNull()->defaultValue(true),
			'[[movable_r]]' => $this->boolean()->notNull()->defaultValue(true),
			'[[removable]]' => $this->boolean()->notNull()->defaultValue(true),
			'[[removable_all]]' => $this->boolean()->notNull()->defaultValue(false),
			'[[name]]' => $this->string(255)->notNull(),
			'[[icon]]' => $this->string(255),
			'[[icon_type]]' => $this->smallInteger(1)->notNull()->defaultValue(1),
			'[[description]]' => $this->text(),
			'[[slug]]' => $this->string(255),
			'[[type]]' => $this->integer(),
			'[[lang_hash]]' => $this->string(255),
			'[[lang]]' => $this->integer(),
		], $tableOptions);

		$this->createIndex('tree_NK1', self::TABLE_NAME, 'root');
		$this->createIndex('tree_NK2', self::TABLE_NAME, 'lft');
		$this->createIndex('tree_NK3', self::TABLE_NAME, 'rgt');
		$this->createIndex('tree_NK4', self::TABLE_NAME, 'lvl');
		$this->createIndex('tree_NK5', self::TABLE_NAME, 'active');

		$this->batchInsert('categories',
			['id', 'root', 'lft', 'rgt', 'lvl', 'active', 'selected', 'disabled', 'readonly', 'visible', 'collapsed', 'movable_u', 'movable_d', 'movable_l', 'movable_r', 'removable', 'removable_all', 'name', 'icon', 'icon_type', 'description', 'slug', 'type', 'lang_hash', 'lang'], [
				['id' => '1', 'root' => '1', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Post', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'post_lotin', 'type' => '100', 'lang_hash' => 'WrkiJ1Q3As81YczgER6YKOBQaYnYB8Hh12QbKVFh61CziVSAI5', 'lang' => '1'],
				['id' => '2', 'root' => '2', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Post', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'post_kiril', 'type' => '100', 'lang_hash' => 'WrkiJ1Q3As81YczgER6YKOBQaYnYB8Hh12QbKVFh61CziVSAI5', 'lang' => '2'],
				['id' => '3', 'root' => '3', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Post', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'post', 'type' => '100', 'lang_hash' => 'WrkiJ1Q3As81YczgER6YKOBQaYnYB8Hh12QbKVFh61CziVSAI5', 'lang' => '3'],
				//////////////
				['id' => '4', 'root' => '4', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Profile', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'profile_lotin', 'type' => '200', 'lang_hash' => '_Rntyzn9si8e5vfHAoRYpyxGNlXeViCOmYFLBXnl-9iPQbq069', 'lang' => '1'],
				['id' => '5', 'root' => '5', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Profile', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'profile_kiril', 'type' => '200', 'lang_hash' => '_Rntyzn9si8e5vfHAoRYpyxGNlXeViCOmYFLBXnl-9iPQbq069', 'lang' => '2'],
				['id' => '6', 'root' => '6', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Profile', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'profile', 'type' => '200', 'lang_hash' => '_Rntyzn9si8e5vfHAoRYpyxGNlXeViCOmYFLBXnl-9iPQbq069', 'lang' => '3'],
				//////////////
				['id' => '7', 'root' => '7', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Products', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'product_lotin', 'type' => '300', 'lang_hash' => '1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDZ', 'lang' => '1'],
				['id' => '8', 'root' => '8', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Products', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'product_kiril', 'type' => '300', 'lang_hash' => '1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDZ', 'lang' => '2'],
				['id' => '9', 'root' => '9', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Products', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'product', 'type' => '300', 'lang_hash' => '1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDZ', 'lang' => '3'],
				//////////////
				['id' => '10', 'root' => '10', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Company', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'company_lotin', 'type' => '400', 'lang_hash' => '_1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDZ', 'lang' => '1'],
				['id' => '11', 'root' => '11', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Company', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'company_kiril', 'type' => '400', 'lang_hash' => '_1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDZ', 'lang' => '2'],
				['id' => '12', 'root' => '12', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Company', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'company', 'type' => '400', 'lang_hash' => '_1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDZ', 'lang' => '3'],
				//////////////
				['id' => '13', 'root' => '13', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Encyclopedia', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'encyclopedia_lotin', 'type' => '500', 'lang_hash' => '_1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDe', 'lang' => '1'],
				['id' => '14', 'root' => '14', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Encyclopedia', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'encyclopedia_kiril', 'type' => '500', 'lang_hash' => '_1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDe', 'lang' => '2'],
				['id' => '15', 'root' => '15', 'lft' => '1', 'rgt' => '4', 'lvl' => '0', 'active' => '1', 'selected' => '0', 'disabled' => '0', 'readonly' => '0', 'visible' => '1', 'collapsed' => '0', 'movable_u' => '1', 'movable_d' => '1', 'movable_l' => '1', 'movable_r' => '1', 'removable' => '1', 'removable_all' => '0', 'name' => 'Encyclopedia', 'icon' => '', 'icon_type' => '1', 'description' => '', 'slug' => 'encyclopedia', 'type' => '500', 'lang_hash' => '_1Ae3e3wCb531nLA_NM0Vk-nyBQwnZtDhQ-3hvHgMsaZQRrNBDe', 'lang' => '3'],

			]
		);

		/**
		 * Создание индекса для создание отношение:
		 * Языка - langs
		 */
		$this->createIndex(
			'idx-categories-langs-lang',
			'{{%categories}}',
			'[[lang]]'
		);
		//Создание отношение
		$this->addForeignKey(
			'fk-categories-langs-lang',
			'{{%categories}}',
			'[[lang]]',
			'{{%langs}}',
			'[[lang_id]]',
			'CASCADE'
		);
		$this->db->createCommand("SELECT setval('categories_id_seq', (SELECT MAX(id)+1 FROM categories))")->execute();
	}


	/**
	 * @inheritdoc
	 */
	public function down()
	{
		$this->dropTable(self::TABLE_NAME);
	}
}