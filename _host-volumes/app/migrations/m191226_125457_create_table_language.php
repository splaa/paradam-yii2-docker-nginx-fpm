<?php

use yii\db\Migration;

/**
 * Class m191226_125457_create_table_language
 */
class m191226_125457_create_table_language extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->createTable('language', [
			'id' => $this->primaryKey(),
			'name' => $this->string(32),
			'code' => $this->string(5),
			'image' => $this->string(64),
			'status' => $this->tinyInteger(3)
		]);

		$this->createIndex(
			'idx-language-id',
			'language',
			'id'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropIndex(
			'idx-language-id',
			'language'
		);

		$this->dropTable('language');

		return false;
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191226_125457_create_table_language cannot be reverted.\n";

        return false;
    }
    */
}
