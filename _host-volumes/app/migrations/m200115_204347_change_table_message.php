<?php

use yii\db\Migration;

/**
 * Class m200115_204347_change_table_message
 */
class m200115_204347_change_table_message extends Migration
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

		$this->createTable('{{%message}}', [
			'id' => $this->primaryKey(),
			'author_id' => $this->integer(),
			'thread_id' => $this->integer(),
			'text' => $this->text(),
			'created_at' => $this->dateTime()
		], $tableOptions);

		$this->createIndex(
			'idx-message-id',
			'{{%message}}',
			'id'
		);

		$this->createIndex(
			'idx-message-author_id',
			'{{%message}}',
			'author_id'
		);

		$this->createIndex(
			'idx-message-thread_id',
			'{{%message}}',
			'thread_id'
		);

		$this->addForeignKey(
			'fk-message-author_id',
			'{{%message}}',
			'author_id',
			'user',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'fk-message-thread_id',
			'{{%message}}',
			'thread_id',
			'{{%thread}}',
			'id',
			'CASCADE'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropForeignKey('fk-message-author_id', '{{%message}}');
		$this->dropForeignKey('fk-message-thread_id', '{{%message}}');
		$this->dropIndex('idx-message-id', '{{%message}}');
		$this->dropIndex('idx-message-author_id', '{{%message}}');
		$this->dropIndex('idx-message-thread_id', '{{%message}}');
		$this->dropTable('{{%message}}');
	}
}
