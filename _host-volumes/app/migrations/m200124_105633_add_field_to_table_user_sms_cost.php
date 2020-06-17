<?php

use yii\db\Migration;

/**
 * Class m200124_105633_add_field_to_table_user_sms_cost
 */
class m200124_105633_add_field_to_table_user_sms_cost extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('user', 'sms_cost', $this->decimal(15, 4)->defaultValue(1.0000));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('user', 'sms_cost');
	}
}
