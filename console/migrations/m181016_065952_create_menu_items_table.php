<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu_items`.
 */
class m181016_065952_create_menu_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu_items}}', [
            '[[menu_item_id]]' => $this->primaryKey(),
            '[[menu_id]]' => $this->integer(),
            '[[title]]' => $this->string(255),
            '[[url]]' => $this->text(),
            '[[icon]]' => $this->string(),
            '[[sort]]' => $this->integer(),
            '[[menu_item_parent_id]]' => $this->integer()->null()
        ]);

        /*
        * Создание индекса для создание отношение:
        * Menu
        */
        $this->createIndex(
            'idx-menu_items-menus-menu_id',
            '{{%menu_items}}',
            '[[menu_id]]'
        );
        //Создание отношение
        $this->addForeignKey(
            'fk-menu-menu_items-menu_id',
            '{{%menu_items}}',
            '[[menu_id]]',
            '{{%menu}}',
            '[[menu_id]]',
            'CASCADE'
        );
        /*
          * Создание индекса для создание отношение:
          * Меню - menu_items
          */
        $this->createIndex(
            'idx-menu_items-menu_items-menu_item_parent_id',
            '{{%menu_items}}',
            '[[menu_item_parent_id]]'
        );
        //Создание отношение
        $this->addForeignKey(
            'fk-menu_items-menu_items-menu_item_parent_id',
            '{{%menu_items}}',
            '[[menu_item_parent_id]]',
            '{{%menu_items}}',
            '[[menu_item_id]]',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*
        * Удаление связи:
        * Menu items - menu_items
        */
        $this->dropForeignKey(
            'fk-menu-menu_items-menu_id',
            '{{%menu_items}}'
        );

        $this->dropIndex(
            'idx-menu_items-menus-menu_id',
            '{{%menu_items}}'
        );

        /*
        * Удаление связи:
        * Menu items - menu_items
        */
        $this->dropForeignKey(
            'fk-menu_items-menu_items-menu_item_parent_id',
            '{{%menu_items}}'
        );

        $this->dropIndex(
            'idx-menu_items-menu_items-menu_item_parent_id',
            '{{%menu_items}}'
        );

        $this->dropTable('{{%menu_items}}');
    }
}
