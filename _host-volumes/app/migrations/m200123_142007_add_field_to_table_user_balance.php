<?php

use yii\db\Migration;

/**
 * Class m200123_142007_add_field_to_table_user_balance
 */
class m200123_142007_add_field_to_table_user_balance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->addColumn('user', 'balance', $this->decimal(15, 4)->defaultValue(0.0000));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->dropColumn('user', 'balance');
    }
}
