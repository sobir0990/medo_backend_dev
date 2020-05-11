<?php

use yii\db\Migration;

/**
 * Handles adding birth to table `profile`.
 */
class m190515_102531_add_company_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('company_reviews', [
            'company_id' => $this->integer(),
            'review_id' => $this->integer(),
        ]);
        $this->addPrimaryKey('pk-company_review', 'company_reviews', ['company_id', 'review_id']);
        $this->addForeignKey(
            'fk-company_reviews-company-id',
            'company_reviews',
            'company_id',
            'company',
            'id',
            'CASCADE', 'CASCADE'
        );
        $this->addForeignKey(
            'fk-company_reviews-review-id',
            'company_reviews',
            'review_id',
            'review',
            'id',
            'CASCADE', 'CASCADE'
        );

        $this->addColumn('company', 'page', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'page');

        $this->dropForeignKey('fk-company_reviews-review-id','company_reviews');
        $this->dropForeignKey('fk-company_reviews-company-id','company_reviews');
        $this->dropTable('company_reviews');
    }
}
