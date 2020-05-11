<?php

use yii\db\Migration;

/**
 * Class m190327_104003_add_phone_view_to_table
 */
class m190327_104003_add_phone_view_to_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('vacation', 'phone_view', $this->integer()->defaultValue(0));
        $this->addColumn('vacation', 'view', $this->integer()->defaultValue(0));
        $this->addColumn('resume', 'phone_view', $this->integer()->defaultValue(0));
        $this->addColumn('resume', 'view', $this->integer()->defaultValue(0));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('vacation', 'view');
        $this->dropColumn('vacation', 'phone_view');
        $this->dropColumn('resume', 'view');
        $this->dropColumn('vacation', 'phone_view');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190327_104003_add_phone_view_to_table cannot be reverted.\n";

        return false;
    }
    */
}
