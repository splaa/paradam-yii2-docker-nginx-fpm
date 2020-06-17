<?php

use yii\db\Migration;

/**
 * Class m191226_130746_create_table_investment
 */
class m191226_130746_create_table_investment extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('investment', [
			'id' => $this->primaryKey(),
			'id_user' => $this->integer(11),
			'id_payer' => $this->integer(11),
			'amount' => $this->decimal(15, 4),
			'created_at' => $this->dateTime()
		]);

		$this->createIndex(
			'idx-investment-id',
			'investment',
			'id'
		);

		$this->createIndex(
			'idx-investment-id_user',
			'investment',
			'id_user'
		);

		$this->createIndex(
			'idx-service-id_payer',
			'investment',
			'id_payer'
		);

		$this->addForeignKey(
			'fk-investment-id_user',
			'investment',
			'id_user',
			'user',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'fk-investment-id_payer',
			'investment',
			'id_payer',
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
			'fk-investment-id_user',
			'investment'
		);

		$this->dropForeignKey(
			'fk-investment-id_payer',
			'investment'
		);

		$this->dropIndex(
			'idx-investment-id',
			'investment'
		);

		$this->dropIndex(
			'idx-investment-id_user',
			'investment'
		);

		$this->dropIndex(
			'idx-investment-id_payer',
			'investment'
		);

		$this->dropTable('investment');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191226_130746_create_table_investment cannot be reverted.\n";

        return false;
    }
    */
}
