<?php

use yii\db\Migration;

/**
 * Class m191225_142333_create_table_content_type_description
 */
class m191225_142333_create_table_content_type_description extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('content_type_description', [
			'id' => $this->primaryKey(),
			'id_content_type' => $this->integer(11),
			'id_language' => $this->integer(11),
			'name' => $this->string(256)
		]);

		$this->createIndex(
			'idx-content_type_description-id',
			'content_type_description',
			'id'
		);

		$this->createIndex(
			'idx-content_type_description-id_content_type',
			'content_type_description',
			'id_content_type'
		);

		$this->createIndex(
			'idx-content_type_description-id_language',
			'content_type_description',
			'id_language'
		);

		$this->addForeignKey(
			'fk-content_type_description-id_content_type',
			'content_type_description',
			'id_content_type',
			'content_type',
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
			'fk-content_type_description-id_content_type',
			'content_type_description'
		);

		$this->dropIndex(
			'idx-content_type_description-id',
			'content_type_description'
		);

		$this->dropIndex(
			'idx-content_type_description-id_content_type',
			'content_type_description'
		);

		$this->dropIndex(
			'idx-content_type_description-id_language',
			'content_type_description'
		);

		$this->dropTable('content_type_description');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142333_create_table_content_type_description cannot be reverted.\n";

        return false;
    }
    */
}
