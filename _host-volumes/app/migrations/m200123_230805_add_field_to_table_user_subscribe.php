<?php

use yii\db\Migration;

/**
 * Class m200123_230805_add_field_to_table_user_subscribe
 */
class m200123_230805_add_field_to_table_user_subscribe extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('user', 'subscribe', $this->tinyInteger('1')->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('user', 'subscribe');
	}
}
