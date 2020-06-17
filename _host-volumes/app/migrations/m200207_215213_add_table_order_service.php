<?php

use yii\db\Migration;

/**
 * Class m200207_215213_add_table_order_service
 */
class m200207_215213_add_table_order_service extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->createTable('{{%order_service}}', [
			'id' => $this->primaryKey(),
			'customer_id' => $this->integer()->notNull(),
			'executor_id' => $this->integer()->notNull(),
			'service_id' => $this->integer()->notNull(),
			'answers' => $this->text(),
			'comment' => $this->text(),
			'status' => $this->tinyInteger()->defaultValue(0)->comment('1 - finish | 0 - started'),
			'amount' => $this->integer(),
			'created_at' => $this->dateTime(),
			'updated_at' => $this->dateTime(),
		]);

		$this->createIndex(
			'{{%idx-order-service-customer_id}}',
			'{{%order_service}}',
			'customer_id'
		);

		$this->createIndex(
			'{{%idx-order-service-executor_id}}',
			'{{%order_service}}',
			'executor_id'
		);

		$this->createIndex(
			'{{%idx-order-service-service_id}}',
			'{{%order_service}}',
			'service_id'
		);

		$this->addForeignKey(
			'{{%fk-order-service-customer_id}}',
			'{{%order_service}}',
			'customer_id',
			'{{%user}}',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'{{%fk-order-service-executor_id}}',
			'{{%order_service}}',
			'executor_id',
			'{{%user}}',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'{{%fk-order-service-service_id}}',
			'{{%order_service}}',
			'service_id',
			'{{%service}}',
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
			'{{%fk-order-service-customer_id}}',
			'{{%order_service}}'
		);

		$this->dropForeignKey(
			'{{%fk-order-service-executor_id}}',
			'{{%order_service}}'
		);

		$this->dropForeignKey(
			'{{%fk-order-service-service_id}}',
			'{{%order_service}}'
		);

		$this->dropIndex(
			'{{%idx-order-service-customer_id}}',
			'{{%order_service}}'
		);

		$this->dropIndex(
			'{{%idx-order-service-executor_id}}',
			'{{%order_service}}'
		);

		$this->dropIndex(
			'{{%idx-order-service-service_id}}',
			'{{%order_service}}'
		);

		$this->dropTable('{{%order_service}}');
	}
}
