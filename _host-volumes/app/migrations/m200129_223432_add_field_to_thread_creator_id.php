<?php

use yii\db\Migration;

/**
 * Class m200129_223432_add_field_to_thread_creator_id
 */
class m200129_223432_add_field_to_thread_creator_id extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('thread', 'creator_id', $this->integer(11)->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('thread', 'creator_id');
	}
}
