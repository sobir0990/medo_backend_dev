<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m181016_065932_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%menu}}', [
            '[[menu_id]]' => $this->primaryKey(),
            '[[title]]' => $this->string(255),
            '[[alias]]' => $this->string(255),
            '[[type]]' => $this->integer(),
            '[[lang_hash]]' => $this->string(255),
            '[[lang]]' => $this->integer(),
        ]);

        /*
        * Создание индекса для создание отношение:
        * Языка - langs
        */
        $this->createIndex(
            'idx-menu-langs-lang',
            '{{%menu}}',
            '[[lang]]'
        );
        //Создание отношение
        $this->addForeignKey(
            'fk-menu-langs-lang',
            '{{%menu}}',
            '[[lang]]',
            '{{%langs}}',
            '[[lang_id]]',
            'CASCADE'
        );

        $this->batchInsert('menu', ['menu_id', 'title', 'alias', 'type', 'lang_hash', 'lang'], [
			array('menu_id' => '3','title' => 'Главное меню','alias' => 'header-menu','type' => '0','lang_hash' => 'cCaBlwLjlB6p6HK65w6Y_aIT1N3OAZJWtzQDEiVcW28PVHPijs','lang' => '3'),
			array('menu_id' => '4','title' => 'Второе меню','alias' => 'second-menu','type' => '0','lang_hash' => 'gV0L4L35uGdBLHicVh4dF2WajdbM5sPmtB7YIcL7HVUcM_lkP7','lang' => '3'),
			array('menu_id' => '6','title' => 'Меню футер','alias' => 'menu-footer','type' => '0','lang_hash' => 'guxm0sLlxDFJ5wldMKQ1WjP33e226G6D0OwzNGQ196wsod78e2','lang' => '3'),
			array('menu_id' => '7','title' => 'Asosiy menyu','alias' => 'header-menu','type' => '0','lang_hash' => 'cCaBlwLjlB6p6HK65w6Y_aIT1N3OAZJWtzQDEiVcW28PVHPijs','lang' => '1'),
			array('menu_id' => '8','title' => 'Ikkilamchi menyu','alias' => 'second-menu','type' => '0','lang_hash' => 'gV0L4L35uGdBLHicVh4dF2WajdbM5sPmtB7YIcL7HVUcM_lkP7','lang' => '1'),
			array('menu_id' => '10','title' => 'Futer menyusi','alias' => 'menu-footer','type' => '0','lang_hash' => 'guxm0sLlxDFJ5wldMKQ1WjP33e226G6D0OwzNGQ196wsod78e2','lang' => '1'),
			array('menu_id' => '11','title' => 'Асосий меню','alias' => 'header-menu','type' => '0','lang_hash' => 'cCaBlwLjlB6p6HK65w6Y_aIT1N3OAZJWtzQDEiVcW28PVHPijs','lang' => '2'),
			array('menu_id' => '12','title' => 'Иккниси меню','alias' => 'second-menu','type' => '0','lang_hash' => 'gV0L4L35uGdBLHicVh4dF2WajdbM5sPmtB7YIcL7HVUcM_lkP7','lang' => '2'),
			array('menu_id' => '14','title' => 'Футер менюси','alias' => 'menu-footer','type' => '0','lang_hash' => 'guxm0sLlxDFJ5wldMKQ1WjP33e226G6D0OwzNGQ196wsod78e2','lang' => '2'),
			array('menu_id' => '15','title' => 'Main menu','alias' => 'header-menu','type' => '0','lang_hash' => 'cCaBlwLjlB6p6HK65w6Y_aIT1N3OAZJWtzQDEiVcW28PVHPijs','lang' => '4'),
			array('menu_id' => '16','title' => 'Second menu','alias' => 'second-menu','type' => '0','lang_hash' => 'gV0L4L35uGdBLHicVh4dF2WajdbM5sPmtB7YIcL7HVUcM_lkP7','lang' => '4'),
			array('menu_id' => '18','title' => 'Footer menu','alias' => 'menu-footer','type' => '0','lang_hash' => 'guxm0sLlxDFJ5wldMKQ1WjP33e226G6D0OwzNGQ196wsod78e2','lang' => '4')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*
         * Удаление связи:
         * Языка - langs
         */
        $this->dropForeignKey(
            'fk-menu-langs-lang',
            '{{%menu}}'
        );

        $this->dropIndex(
            'idx-menu-langs-lang',
            '{{%menu}}'
        );

        $this->dropTable('{{%menu}}');
    }
}
