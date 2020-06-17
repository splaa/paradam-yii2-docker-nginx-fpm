<?php

use yii\db\Migration;

/**
 * Class m200115_204452_create_table_user_message
 */
class m200115_204452_create_table_user_message extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		// Create new Table
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
		}

		$this->createTable('{{%user_message}}', [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer(),
			'message_id' => $this->integer()
		], $tableOptions);

		$this->createIndex(
			'idx-user_message-id',
			'{{%user_message}}',
			'id'
		);

		$this->createIndex(
			'idx-user_message-user_id',
			'{{%user_message}}',
			'user_id'
		);

		$this->createIndex(
			'idx-user_message-message_id',
			'{{%user_message}}',
			'message_id'
		);

		$this->addForeignKey(
			'fk-user_message-user_id',
			'{{%user_message}}',
			'user_id',
			'user',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'fk-user_message-message_id',
			'{{%user_message}}',
			'message_id',
			'{{%message}}',
			'id',
			'CASCADE'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropForeignKey('fk-user_message-user_id', '{{%user_message}}');
		$this->dropForeignKey('fk-user_message-message_id', '{{%user_message}}');
		$this->dropIndex('idx-user_message-id', '{{%user_message}}');
		$this->dropIndex('idx-user_message-user_id', '{{%user_message}}');
		$this->dropIndex('idx-user_message-message_id', '{{%user_message}}');
		$this->dropTable('{{%user_message}}');
	}
}
