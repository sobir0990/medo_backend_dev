<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m190118_024030_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'profile_id' => $this->integer(11),
            'product_id' => $this->integer(11),
            'text' => $this->text(),
            'rating' => $this->tinyInteger(),
            'type' => $this->tinyInteger(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('ind-review-profile-profile_id','review','profile_id');
        $this->createIndex('ind-review-product_id','review','product_id');

        $this->addForeignKey('fk-review-profile_id-profile-id',
            'review',
            'profile_id',
            'profile',
            'id',
            'CASCADE'
        );

        $this->addForeignKey('fk-review-product_id-product-id',
            'review',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropIndex('ind-review-profile-profile_id','review');
        $this->dropIndex('ind-review-product_id','review');
        $this->dropForeignKey('fk-review-profile_id-profile-id','review');
        $this->dropForeignKey('fk-review-product_id-product-id','review');
        $this->dropTable('{{%review}}');
    }
}
