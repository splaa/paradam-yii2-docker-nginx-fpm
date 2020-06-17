<?php

use yii\db\Migration;

/**
 * Class m200222_165847_add_field_to_thread_updated_at
 */
class m200222_165847_add_field_to_thread_updated_at extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->addColumn('thread', 'updated_at', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->dropColumn('thread', 'updated_at');
    }
}
