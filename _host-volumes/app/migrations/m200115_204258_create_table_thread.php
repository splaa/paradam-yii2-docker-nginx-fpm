<?php

use yii\db\Migration;

/**
 * Class m200115_204258_create_table_thread
 */
class m200115_204258_create_table_thread extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            // DROP TABLE message
			$message = new m191225_142149_create_table_message();
			$message->safeDown();
			
			// Create new Table
			$tableOptions = null;
			if ($this->db->driverName === 'mysql') {
				$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
			}
			
			$this->createTable('{{%thread}}', [
				'id' => $this->primaryKey(),
				'title' => $this->string(),
				'created_at' => $this->dateTime()
			], $tableOptions);
			
			$this->createIndex(
				'idx-thread-id',
				'thread',
				'id'
			);
		}
		
		/**
		 * {@inheritdoc}
		 */
		public function safeDown()
		{
			$this->dropIndex('idx-thread-id', '{{%thread}}');
			$this->dropTable('{{%thread}}');

			// DROP TABLE message
			$message = new m191225_142149_create_table_message();
			$message->safeUp();
		}
	}
