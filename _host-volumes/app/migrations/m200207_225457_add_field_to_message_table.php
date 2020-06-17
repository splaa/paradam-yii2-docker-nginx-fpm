<?php

use yii\db\Migration;

/**
 * Class m200207_225457_add_field_to_message_table
 */
class m200207_225457_add_field_to_message_table extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('message', 'order_service_id', $this->integer());

		$this->createIndex(
			'{{%idx-message-order_service_id}}',
			'{{%message}}',
			'order_service_id'
		);

		$this->addForeignKey(
			'{{%fk-message-order_service_id}}',
			'{{%message}}',
			'order_service_id',
			'{{%order_service}}',
			'id',
			'CASCADE'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropForeignKey(
			'{{%fk-message-order_service_id}}',
			'{{%message}}'
		);

		$this->dropIndex(
			'{{%idx-message-order_service_id}}',
			'{{%message}}'
		);

		$this->dropColumn('message', 'order_service_id');
	}
}
