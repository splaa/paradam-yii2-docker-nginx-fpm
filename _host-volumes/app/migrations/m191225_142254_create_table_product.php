<?php

use yii\db\Migration;

/**
 * Class m191225_142254_create_table_product
 */
class m191225_142254_create_table_product extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('product', [
			'id' => $this->primaryKey(),
			'id_user' => $this->integer(11),
			'id_category' => $this->integer(11),
			'price' => $this->decimal(15, 4),
			'quantity' => $this->integer(11),
			'created_at' => $this->dateTime(),
			'updated_at' => $this->dateTime()
		]);

		$this->createIndex(
			'idx-product-id',
			'product',
			'id'
		);

		$this->createIndex(
			'idx-product-id_user',
			'product',
			'id_user'
		);

		$this->createIndex(
			'idx-product-id_category',
			'product',
			'id_category'
		);

		$this->addForeignKey(
			'fk-product-id_user',
			'product',
			'id_user',
			'user',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'fk-product-id_category',
			'product',
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
			'fk-product-id_user',
			'product'
		);

		$this->dropForeignKey(
			'fk-product-id_category',
			'product'
		);

		$this->dropIndex(
			'idx-product-id',
			'product'
		);

		$this->dropIndex(
			'idx-product-id_user',
			'product'
		);

		$this->dropIndex(
			'idx-product-id_category',
			'product'
		);

		$this->dropTable('product');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_142254_create_table_product cannot be reverted.\n";

        return false;
    }
    */
}
