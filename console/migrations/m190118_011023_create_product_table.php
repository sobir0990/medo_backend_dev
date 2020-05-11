<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m190118_011023_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer(11),
            'company_id' => $this->integer(11),
            'images' => $this->string(255),
            'title' => $this->string(255),
            'content'  =>  $this->text(),
            'type' => $this->tinyInteger()->defaultValue(0),
            'status' => $this->tinyInteger()->defaultValue(0),
            'price' => $this->integer(11),
            'price_to' => $this->integer(11),
            'price_type'=> $this->tinyInteger()->defaultValue(0),
            'phone' => $this->string(20),
            'files' => $this->string(255),
            'lang' => $this->integer(11),
            'lang_hash' => $this->string(255),
            'delivery'=> $this->tinyInteger(),
            'address' => $this->string(255),
            'top' => $this->integer(11)->defaultValue(0),
            'view' => $this->integer(11)->defaultValue(0),
            'view_phone' => $this->integer(11)->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

    $this->createIndex('ind-product-profile_id','product','profile_id');
    $this->createIndex('ind-product-company_id','product','company_id');

    $this->addForeignKey(
        'fk-product-product-profile-id',
        'product',
        'profile_id',
        'profile',
        'id',
        'CASCADE'
    );
    $this->addForeignKey(
        'fk-product-product-company_id-company-id',
        'product',
        'company_id',
        'company',
        'id',
        'CASCADE'
    );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('ind-product-profile_id','product');
        $this->dropIndex('ind-product-company_id','product');
        $this->dropForeignKey( 'fk-product-product-profile-id','product');
        $this->dropForeignKey('fk-product-product-company_id-company-id','product');
        $this->dropTable('{{%product}}');
    }
}
