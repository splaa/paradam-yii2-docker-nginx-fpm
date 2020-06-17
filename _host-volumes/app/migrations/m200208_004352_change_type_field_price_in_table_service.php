<?php

use yii\db\Migration;

/**
 * Class m200208_004352_change_type_field_price_in_table_service
 */
class m200208_004352_change_type_field_price_in_table_service extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->alterColumn('service', 'price', $this->integer(11));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->alterColumn('service', 'price', $this->decimal(15, 4)->defaultValue(1.0000));
	}
}
