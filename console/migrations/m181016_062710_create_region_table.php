<?php

use yii\db\Migration;

/**
 * Handles the creation of table `region`.
 */
class m181016_062710_create_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('region', [
            'id' => $this->primaryKey(),
			'country_id' => $this->integer(),
			'name' => $this->string(32)->notNull(),
			'lat' => $this->double(),
			'lon' => $this->double()
        ]);

        $this->batchInsert('region', ['country_id', 'name'],
		  [
		    [1, "Андижанская область"],
		    [1, "Бухарская область"],
		    [1, "Ташкентская область"],
		    [1, "Ферганская область"],
		    [1, "Джиззакская область"],
		    [1, "Каракалпакстан"],
		    [1, "Кашкадарьинская область"],
		    [1, "Хорезмская область"],
		    [1, "Наманганская область"],
		    [1, "Навоиская область"],
		    [1, "Самаркандская область"],
		    [1, "Сурхандарьинская область"],
		    [1, "Сырдарьинская область"],
		    [1, "Город Ташкент"],
		  ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('region');
    }
}
