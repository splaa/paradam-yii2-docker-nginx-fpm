<?php

use yii\db\Migration;

/**
 * Class m191225_142045_create_table_service
 */
class m191225_142045_create_table_service extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->createTable('service', [
		    'id' => $this->primaryKey(),
		    'user_id' => $this->integer(11),
		    'name' => $this->string(256),
		    'description' => $this->text(),
		    'price' => $this->decimal(15,4),
		    'created_at' => $this->dateTime()
	    ]);

	    $this->createIndex(
		    'idx-service-id',
		    'service',
		    'id'
	    );

	    $this->createIndex(
		    'idx-service-user_id',
		    'service',
		    'user_id'
	    );

	    // add foreign key for table `user`
	    $this->addForeignKey(
		    'fk-service-user_id',
		    'service',
		    'user_id',
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
	    // drops foreign key for table `user`
	    $this->dropForeignKey(
		    'fk-service-user_id',
		    'service'
	    );

	    // drops index for column `author_id`
	    $this->dropIndex(
		    'idx-service-user_id',
		    'service'
	    );

        $this->dropTable('service');

        return false;
    }
}
