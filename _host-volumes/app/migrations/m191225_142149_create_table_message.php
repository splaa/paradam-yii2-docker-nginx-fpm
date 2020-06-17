<?php

use yii\db\Migration;

/**
 * Class m191225_142149_create_table_message
 */
class m191225_142149_create_table_message extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('message', [
			'id' => $this->primaryKey(),
			'id_sender' => $this->integer(11),
			'id_recipient' => $this->integer(11),
			'id_service' => $this->integer(11),
			'message' => $this->text(),
			'created_at' => $this->dateTime()
		]);

		$this->createIndex(
			'idx-message-id',
			'message',
			'id'
		);

		$this->createIndex(
			'idx-message-id_sender',
			'message',
			'id_sender'
		);

		$this->createIndex(
			'idx-message-id_recipient',
			'message',
			'id_recipient'
		);

		$this->createIndex(
			'idx-message-id_service',
			'message',
			'id_service'
		);

		$this->addForeignKey(
			'fk-message-id_sender',
			'message',
			'id_sender',
			'user',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'fk-message-id_recipient',
			'message',
			'id_recipient',
			'user',
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
			'fk-message-id_sender',
			'message'
		);

		$this->dropForeignKey(
			'fk-message-id_recipient',
			'message'
		);

		$this->dropIndex(
			'idx-message-id',
			'message'
		);

		$this->dropIndex(
			'idx-message-id_sender',
			'message'
		);

		$this->dropIndex(
			'idx-message-id_recipient',
			'message'
		);

		$this->dropIndex(
			'idx-message-id_service',
			'message'
		);

		$this->dropTable('message');

		return false;
	}
}
