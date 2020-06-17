<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%froze}}`.
 */
class m200213_213032_create_froze_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%froze}}', [
            'id' => $this->primaryKey(),
	        'amount' => $this->integer(),
	        'message_id' => $this->integer(),
	        'thread_id' => $this->integer(),
	        'status' => $this->tinyInteger(1)->defaultValue(0),
	        'created_at' => $this->dateTime(),
        ]);

	    $this->createIndex(
		    'idx-froze-id',
		    '{{%froze}}',
		    'id'
	    );

	    $this->createIndex(
		    'idx-froze-message_id',
		    '{{%froze}}',
		    'message_id'
	    );

	    $this->createIndex(
		    'idx-froze-thread_id',
		    '{{%froze}}',
		    'thread_id'
	    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->dropIndex('idx-froze-thread_id', '{{%froze}}');
	    $this->dropIndex('idx-froze-message_id', '{{%froze}}');
	    $this->dropIndex('idx-froze-id', '{{%froze}}');
        $this->dropTable('{{%froze}}');
    }
}
