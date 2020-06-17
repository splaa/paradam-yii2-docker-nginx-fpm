<?php

use yii\db\Migration;

/**
 * Class m200202_135546_add_field_to_message_audio
 */
class m200202_135546_add_field_to_message_audio extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
	{
		$this->addColumn('message', 'audio', $this->string(256)->defaultValue(''));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('message', 'audio');
	}
}
