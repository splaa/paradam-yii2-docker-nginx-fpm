<?php

use yii\db\Migration;

/**
 * Class m200108_204736_add_field_to_user_first_name_and_last_name
 */
class m200108_204736_add_field_to_user_first_name_and_last_name extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('user', 'first_name', $this->string(256));
		$this->addColumn('user', 'last_name', $this->string(256));
		$this->addColumn('user', 'country', $this->string(256));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('user', 'first_name');
		$this->dropColumn('user', 'last_name');
		$this->dropColumn('user', 'country');
	}
}
