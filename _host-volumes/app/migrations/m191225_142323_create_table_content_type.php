<?php

use yii\db\Migration;

/**
 * Class m191225_142323_create_table_content_type
 */
class m191225_142323_create_table_content_type extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('content_type', [
			'id' => $this->primaryKey(),
			'status' => $this->tinyInteger(1),
			'created_at' => $this->dateTime(),
			'updated_at' => $this->dateTime(),
		]);

		$this->createIndex(
			'idx-content_type-id',
			'content_type',
			'id'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropIndex(
			'idx-content_type-id',
			'content_type'
		);

		$this->dropTable('content_type');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142323_create_table_content_type cannot be reverted.\n";

        return false;
    }
    */
}
