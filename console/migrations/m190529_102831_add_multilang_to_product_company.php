<?php

use yii\db\Migration;

/**
 */
class m190529_102831_add_multilang_to_product_company extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product', 'title_ru', $this->string(255));
        $this->addColumn('product', 'content_ru', $this->text());
        $this->renameColumn('product', 'title', 'title_uz');
        $this->renameColumn('product', 'content', 'content_uz');
        $this->addColumn('company', 'name_ru', $this->string(255));
        $this->addColumn('company', 'description_ru', $this->text());
        $this->addColumn('company', 'page_ru', $this->text());
        $this->renameColumn('company', 'name', 'name_uz');
        $this->alterColumn('company', 'description', $this->text());
        $this->renameColumn('company', 'description', 'description_uz');
        $this->renameColumn('company', 'page', 'page_uz');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('company', 'name_ru');
        $this->dropColumn('company', 'description_ru');
        $this->dropColumn('company', 'page_ru');

        $this->renameColumn('company', 'name_uz','name' );
        $this->renameColumn('company', 'description_uz','description' );
        $this->alterColumn('company', 'description', $this->string(255));
        $this->renameColumn('company', 'page_uz','page' );

        $this->dropColumn('product', 'title_ru');
        $this->dropColumn('product', 'content_ru');
        $this->renameColumn('product', 'title_uz', 'title');
        $this->renameColumn('product', 'content_uz', 'content');
    }
}
