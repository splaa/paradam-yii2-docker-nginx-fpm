<?php

use yii\db\Migration;

/**
 * Class m191225_142341_create_table_content
 */
class m191225_142341_create_table_content extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('content', [
			'id' => $this->primaryKey(),
			'id_content_type' => $this->integer(11),
			'id_user' => $this->integer(11),
			'price' => $this->decimal(15, 4),
			'name' => $this->string(256),
			'description' => $this->text(),
			'data' => $this->text(),
			'created_at' => $this->dateTime()
		]);

		$this->createIndex(
			'idx-content-id',
			'content',
			'id'
		);

		$this->createIndex(
			'idx-content-id_content_type',
			'content',
			'id_content_type'
		);

		$this->createIndex(
			'idx-service-id_user',
			'content',
			'id_user'
		);

		$this->addForeignKey(
			'fk-content-id_content_type',
			'content',
			'id_content_type',
			'content_type',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'fk-content-id_user',
			'content',
			'id_user',
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
			'fk-content-id_content_type',
			'content'
		);

		$this->dropForeignKey(
			'fk-content-id_user',
			'content'
		);

		$this->dropIndex(
			'idx-content-id',
			'content'
		);
		$this->dropIndex(
			'idx-content-id_content_type',
			'content'
		);

		$this->dropIndex(
			'idx-content-id_user',
			'content'
		);

		$this->dropTable('content');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142341_create_table_content cannot be reverted.\n";

        return false;
    }
    */
}
