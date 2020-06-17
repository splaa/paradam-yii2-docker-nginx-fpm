<?php

use yii\db\Migration;

/**
 * Class m200422_210244_add_languages_field_to_user_table
 */
class m200422_210244_add_languages_field_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('user', 'languages', $this->text());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('user', 'languages');
	}
}
