<?php

use yii\db\Migration;

/**
 * Class m191225_142301_create_table_product_description
 */
class m191225_142301_create_table_product_description extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('product_description', [
			'id' => $this->primaryKey(),
			'id_product' => $this->integer(11),
			'id_language' => $this->integer(11),
			'name' => $this->string(256),
			'title' => $this->string(256),
			'description' => $this->text(),
			'meta_keywords' => $this->text(),
			'meta_description' => $this->text(),
		]);

		$this->createIndex(
			'idx-product_description-id',
			'product_description',
			'id'
		);

		$this->createIndex(
			'idx-product_description-id_product',
			'product_description',
			'id_product'
		);

		$this->createIndex(
			'idx-product_description-id_language',
			'product_description',
			'id_language'
		);
		$this->addForeignKey(
			'fk-product_description-id_product',
			'product_description',
			'id_product',
			'product',
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
			'fk-product_description-id_product',
			'product_description'
		);

		$this->dropIndex(
			'idx-product_description-id',
			'product_description'
		);

		$this->dropIndex(
			'idx-product_description-id_product',
			'product_description'
		);

		$this->dropIndex(
			'idx-product_description-id_language',
			'product_description'
		);

		$this->dropTable('product_description');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142301_create_table_product_description cannot be reverted.\n";

        return false;
    }
    */
}
