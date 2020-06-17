<?php

use yii\db\Migration;

/**
 * Class m200115_204324_create_table_user_thread
 */
class m200115_204324_create_table_user_thread extends Migration
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

	    $this->createTable('{{%user_thread}}', [
		    'id' => $this->primaryKey(),
		    'user_id' => $this->integer(),
		    'thread_id' => $this->integer(),
	    ], $tableOptions);

	    $this->createIndex(
		    'idx-user_thread-id',
		    'user_thread',
		    'id'
	    );

	    $this->createIndex(
		    'idx-user_thread-user_id',
		    'user_thread',
		    'user_id'
	    );

	    $this->createIndex(
		    'idx-user_thread-thread_id',
		    'user_thread',
		    'thread_id'
	    );

	    $this->addForeignKey(
		    'fk-user_thread-user_id',
		    'user_thread',
		    'user_id',
		    'user',
		    'id',
		    'CASCADE'
	    );

	    $this->addForeignKey(
		    'fk-user_thread-thread_id',
		    'user_thread',
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
    	$this->dropForeignKey('fk-user_thread-user_id', '{{%user_thread}}');
    	$this->dropForeignKey('fk-user_thread-thread_id', '{{%user_thread}}');
		$this->dropIndex('idx-user_thread-id', '{{%user_thread}}');
		$this->dropIndex('idx-user_thread-user_id', '{{%user_thread}}');
		$this->dropIndex('idx-user_thread-thread_id', '{{%user_thread}}');
		$this->dropTable('{{%user_thread}}');
    }
}
