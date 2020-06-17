<?php

use yii\db\Migration;

/**
 * Class m200305_212438_add_field_to_user_table_description_link
 */
class m200305_212438_add_field_to_user_table_description_link extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('user', 'description', $this->text());
		$this->addColumn('user', 'link', $this->string('100'));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('user', 'description');
		$this->dropColumn('user', 'link');
	}
}
