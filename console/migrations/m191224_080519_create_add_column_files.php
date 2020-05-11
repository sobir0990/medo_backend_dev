<?php

use yii\db\Migration;

/**
 * Class m191224_080519_create_add_column_files
 */
class m191224_080519_create_add_column_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('files', 'slug', $this->string());
        $this->addColumn('files', 'name', $this->text());
        $this->addColumn('files', 'ext', $this->string());
        $this->addColumn('files', 'folder', $this->text());
        $this->addColumn('files', 'domain', $this->text());
        $this->addColumn('files', 'created_at', $this->integer());
        $this->addColumn('files', 'updated_at', $this->integer());
        $this->addColumn('files', 'status', $this->string());
        $this->addColumn('files', 'upload_data', $this->text());
        $this->addColumn('files', 'path', $this->string());
        $this->addColumn('files', 'size', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('files', 'slug');
        $this->dropColumn('files', 'name');
        $this->dropColumn('files', 'ext');
        $this->dropColumn('files', 'folder');
        $this->dropColumn('files', 'domain');
        $this->dropColumn('files', 'created_at');
        $this->dropColumn('files', 'updated_at');
        $this->dropColumn('files', 'status');
        $this->dropColumn('files', 'upload_data');
        $this->dropColumn('files', 'path');
        $this->dropColumn('files', 'size');
    }

}
