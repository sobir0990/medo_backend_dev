<?php

use yii\db\Migration;

/**
 * Class m200108_075303_create_table_banner
 */
class m200108_075303_create_table_banner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('banner', [
           'id' => $this->primaryKey(),
           'title' => $this->string(),
           'slug' => $this->string(),
           'link' => $this->string(254),
           'image' => $this->string(),
           'status' => $this->integer(),
           'type' => $this->integer(),
           'created_at' => $this->integer(),
           'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('banner');
    }

}
