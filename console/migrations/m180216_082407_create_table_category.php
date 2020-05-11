<?php

use yii\db\Migration;

/**
 * Class m191204_121235_create_table_category
 */
class m180216_082407_create_table_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(254),
            'parent_id' => $this->integer(),
            'status' => $this->integer(),
            'sort' => $this->integer(),
            'lang' => $this->integer(),
            'lang_hash' => $this->string(254)
        ]);

//        $this->batchInsert('map', ['name', 'status', 'lang', 'lang_hash'],
//            [
//                ['Products', '10', '3', ''],
//                ['Encyclopedia', '10', '3', ''],
//                ['Resume', '10', '3', ''],
//                ['Company', '10', '3', ''],
//                ['Profile', '10', '3', ''],
//                ['Vacation', '10', '3', ''],
//                ['Post', '10', '3', ''],
//            ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }


}
