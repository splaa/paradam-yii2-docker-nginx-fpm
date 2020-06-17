<?php

use yii\db\Migration;

/**
 * Class m191225_142203_create_table_category
 */
class m191225_142203_create_table_category extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('category', [
			'id' => $this->primaryKey(),
			'status' => $this->tinyInteger(1),
			'created_at' => $this->dateTime(),
			'updated_at' => $this->dateTime(),
		]);

		$this->createIndex(
			'idx-category-id',
			'category',
			'id'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropIndex(
			'idx-category-id',
			'category'
		);

		$this->dropTable('category');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142203_create_table_category cannot be reverted.\n";

        return false;
    }
    */
}
