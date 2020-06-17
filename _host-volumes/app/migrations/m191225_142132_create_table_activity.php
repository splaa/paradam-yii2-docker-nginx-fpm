<?php

use yii\db\Migration;

/**
 * Class m191225_142132_create_table_activity
 */
class m191225_142132_create_table_activity extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('activity', [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer(11),
			'type' => $this->integer(2),
			'additional' => $this->text(),
			'created_at' => $this->dateTime(),
		]);

		$this->addCommentOnColumn(
			'activity',
			'type',
			'1 => profile, 2 => service, 3 => photo, 4 => video, 5 => products, 6 => investition'
		);

		$this->createIndex(
			'idx-activity-id',
			'activity',
			'id'
		);

		$this->createIndex(
			'idx-activity-user_id',
			'activity',
			'user_id'
		);
		$this->addForeignKey(
			'fk-activity-user_id',
			'activity',
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
			'fk-activity-user_id',
			'activity'
		);

		$this->dropIndex(
			'idx-activity-id',
			'activity'
		);

		$this->dropIndex(
			'idx-activity-user_id',
			'activity'
		);

		$this->dropTable('activity');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142132_create_table_activity cannot be reverted.\n";

        return false;
    }
    */
}
