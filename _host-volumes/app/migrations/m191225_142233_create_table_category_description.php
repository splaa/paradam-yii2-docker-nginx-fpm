<?php

use yii\db\Migration;

/**
 * Class m191225_142233_create_table_category_description
 */
class m191225_142233_create_table_category_description extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('category_description', [
			'id' => $this->primaryKey(),
			'id_category' => $this->integer(11),
			'id_language' => $this->integer(11),
			'name' => $this->string(256),
			'title' => $this->string(256),
			'description' => $this->text(),
			'meta_keywords' => $this->text(),
			'meta_description' => $this->text(),
		]);

		$this->createIndex(
			'idx-category_description-id',
			'category_description',
			'id'
		);

		$this->createIndex(
			'idx-category_description-id_category',
			'category_description',
			'id_category'
		);

		$this->addForeignKey(
			'fk-category_description-id_category',
			'category_description',
			'id_category',
			'category',
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
			'fk-category_description-id_category',
			'category_description'
		);
		$this->dropIndex(
			'idx-category_description-id',
			'category_description'
		);

		$this->dropIndex(
			'idx-category_description-id_category',
			'category_description'
		);

		$this->dropTable('category_description');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142233_create_table_category_description cannot be reverted.\n";

        return false;
    }
    */
}
