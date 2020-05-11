<?php

use yii\db\Migration;

/**
 * Handles the creation of table `favorite_product`.
 */
class m190208_061343_create_favorite_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('favorite_product', [
            'profile_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addPrimaryKey('upk-favorite_product', 'favorite_product', ['profile_id', 'product_id']);

        $this->createIndex('idx_favorite_product__profile_id', 'favorite_product', 'profile_id');
        $this->createIndex('idx_favorite_product__product_id', 'favorite_product', 'product_id');

        $this->addForeignKey('fk-profile_id-favorite_product',
            'favorite_product',
            'profile_id',
            'profile',
            'id',
            'CASCADE');

        $this->addForeignKey('fk-product_id-favorite_product',
            'favorite_product',
            'product_id',
            'product',
            'id',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_favorite_product__profile_id', 'favorite_product');
        $this->dropIndex('idx_favorite_product__product_id', 'favorite_product');

        $this->dropTable('favorite_product');
    }
}
