<?php

use yii\db\Migration;

/**
 * Class m200127_201652_add_field_to_user_table_birthday_change
 */
class m200127_201652_add_field_to_user_table_birthday_change extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('user', 'birthday_change', $this->tinyInteger(1)->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('user', 'birthday_change');
	}
}
