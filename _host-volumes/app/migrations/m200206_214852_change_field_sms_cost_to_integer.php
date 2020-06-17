<?php

use yii\db\Migration;

/**
 * Class m200206_214852_change_field_sms_cost_to_integer
 */
class m200206_214852_change_field_sms_cost_to_integer extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->alterColumn('user', 'sms_cost', $this->integer(11));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->alterColumn('user', 'sms_cost', $this->decimal(15, 4)->defaultValue(1.0000));
	}
}
