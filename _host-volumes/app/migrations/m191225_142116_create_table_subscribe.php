<?php

use yii\db\Migration;

/**
 * Class m191225_142116_create_table_subscribe
 */
class m191225_142116_create_table_subscribe extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('subscribe', [
			'id' => $this->primaryKey(),
			'subscriber_id' => $this->integer(11),
			'user_id' => $this->integer(11),
			'created_at' => $this->dateTime()
		]);

		$this->createIndex(
			'idx-subscribe-id',
			'subscribe',
			'id'
		);

		$this->createIndex(
			'idx-subscribe-subscriber_id',
			'subscribe',
			'subscriber_id'
		);

		$this->createIndex(
			'idx-subscribe-user_id',
			'subscribe',
			'user_id'
		);
		$this->addForeignKey(
			'fk-subscribe-subscriber_id',
			'subscribe',
			'subscriber_id',
			'user',
			'id',
			'CASCADE'
		);
		$this->addForeignKey(
			'fk-subscribe-user_id',
			'subscribe',
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
		$this->dropForeignKey(
			'fk-subscribe-subscriber_id',
			'subscribe'
		);

		$this->dropForeignKey(
			'fk-subscribe-user_id',
			'subscribe'
		);

		$this->dropIndex(
			'idx-subscribe-id',
			'subscribe'
		);

		$this->dropIndex(
			'idx-subscribe-subscriber_id',
			'subscribe'
		);

		$this->dropIndex(
			'idx-subscribe-user_id',
			'subscribe'
		);

		$this->dropTable('subscribe');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142116_create_table_subscribe cannot be reverted.\n";

        return false;
    }
    */
}
