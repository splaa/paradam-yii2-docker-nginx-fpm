<?php

use yii\db\Migration;

/**
 * Class m200213_162249_add_field_to_message_cancel
 */
class m200213_162249_add_field_to_message_cancel extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('message', 'cancel', $this->tinyInteger('1')->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('message', 'cancel');
	}
}
