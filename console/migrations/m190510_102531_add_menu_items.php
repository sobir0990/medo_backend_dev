<?php

use yii\db\Migration;

/**
 * Handles adding birth to table `profile`.
 */
class m190510_102531_add_menu_items extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Header menu
        $this->insert('menu_items', ['menu_id' => '11', 'title' => 'Работа', 'url' => '/work']);
        $this->insert('menu_items', ['menu_id' => '11', 'title' => 'Доска объявлений', 'url' => '/dashboard']);
        $this->insert('menu_items', ['menu_id' => '11', 'title' => 'Товары и сервисы', 'url' => '/product_services']);

        // Side menu
        $this->insert('menu_items', ['menu_id' => '12', 'title' => 'Новости', 'url' => '/news']);
        $this->insert('menu_items', ['menu_id' => '12', 'title' => 'Товары и услуги', 'url' => '/product_services']);
        $this->insert('menu_items', ['menu_id' => '12', 'title' => 'Работа', 'url' => '/work']);
        $this->insert('menu_items', ['menu_id' => '12', 'title' => 'Учереждения', 'url' => '/companies']);
        $this->insert('menu_items', ['menu_id' => '12', 'title' => 'Энциклопедия', 'url' => '/encyclopedia']);
        $this->insert('menu_items', ['menu_id' => '12', 'title' => 'Доска объявлений', 'url' => '/dashboard']);
        $this->insert('menu_items', ['menu_id' => '12', 'title' => 'Правовые акты', 'url' => '/acts']);

        // Header menu rus
        $this->insert('menu_items', ['menu_id' => '3', 'title' => 'Работа', 'url' => '/work']);
        $this->insert('menu_items', ['menu_id' => '3', 'title' => 'Доска объявлений', 'url' => '/dashboard']);
        $this->insert('menu_items', ['menu_id' => '3', 'title' => 'Товары и сервисы', 'url' => '/product_services']);

        // Side menu rus
        $this->insert('menu_items', ['menu_id' => '4', 'title' => 'Новости', 'url' => '/news']);
        $this->insert('menu_items', ['menu_id' => '4', 'title' => 'Товары и услуги', 'url' => '/product_services']);
        $this->insert('menu_items', ['menu_id' => '4', 'title' => 'Работа', 'url' => '/work']);
        $this->insert('menu_items', ['menu_id' => '4', 'title' => 'Учереждения', 'url' => '/companies']);
        $this->insert('menu_items', ['menu_id' => '4', 'title' => 'Энциклопедия', 'url' => '/encyclopedia']);
        $this->insert('menu_items', ['menu_id' => '4', 'title' => 'Доска объявлений', 'url' => '/dashboard']);
        $this->insert('menu_items', ['menu_id' => '4', 'title' => 'Правовые акты', 'url' => '/acts']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('menu_items');
    }
}
