<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile}}`.
 */
class m190117_071727_create_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'profession_id' => $this->integer(),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'middle_name' => $this->string(255),
            'bio' => $this->text(),
            'gender' => $this->tinyInteger()->defaultValue(0),
            'birth' => $this->integer(),
            'type' => $this->tinyInteger()->defaultValue(0),
            'status' => $this->tinyInteger()->defaultValue(0),
            'balance' => $this->integer(11)->defaultValue(0),
            'region_id' => $this->integer(11),
            'city_id' => $this->integer(11),
            'social' => $this->text(),
            'image' => $this->string(255),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->createIndex('idx_profile_user_id', 'profile', 'user_id');
        $this->createIndex('idx_profile_city_id', 'profile', 'city_id');
        $this->createIndex('idx_profile_region_id', 'profile', 'region_id');

        $this->addForeignKey(
            'fk_user_id_profile',
            'profile', 'user_id',
            'user', 'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_city_id_profile',
            'profile', 'city_id',
            'city', 'id',
            'CASCADE'
        );

//        $this->addForeignKey(
//            'fk_region_id_profile',
//            'profile', 'region_id',
//            'region', 'id',
//            'CASCADE'
//        );

		$profile = new \common\models\Profile();
        $profile->load(array(
            'user_id' => '1',
            'first_name' => 'Admin',
            'last_name' => 'Super',
            'gender' => 1,
        ), '');
        $profile->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_id_profile', 'profile');

        $this->dropIndex('idx_profile_user_id', 'profile');
        $this->dropIndex('idx_profile_city_id', 'profile');
        $this->dropIndex('idx_profile_region_id', 'profile');

        $this->dropTable('profile');
    }
}
