<?php

use yii\db\Migration;

/**
 * Handles the creation of table `favorite_vacations`.
 */
class m190208_061402_create_favorite_vacations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('favorite_vacations', [
            'profile_id' => $this->integer()->notNull(),
            'vacation_id' => $this->integer()->notNull(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addPrimaryKey('upk-favorite_vacations', 'favorite_vacations', ['profile_id', 'vacation_id']);

        $this->createIndex('idx_favorite_vacations__profile_id', 'favorite_vacations', 'profile_id');
        $this->createIndex('idx_favorite_vacations__vacation_id', 'favorite_vacations', 'vacation_id');

        $this->addForeignKey('fk-profile_id-favorite_vacations',
            'favorite_vacations',
            'profile_id',
            'profile',
            'id',
            'CASCADE');

        $this->addForeignKey('fk-vacation_id-favorite_vacations',
            'favorite_vacations',
            'vacation_id',
            'vacation',
            'id',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_favorite_vacations__profile_id', 'favorite_vacations');
        $this->dropIndex('idx_favorite_vacations__vacation_id', 'favorite_vacations');

        $this->dropTable('favorite_vacations');
    }
}
