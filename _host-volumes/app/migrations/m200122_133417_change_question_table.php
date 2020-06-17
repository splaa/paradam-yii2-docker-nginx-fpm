<?php

use yii\db\Migration;

/**
 * Class m200122_133417_change_question_table
 */
class m200122_133417_change_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->alterColumn('question', 'created_at', $this->dateTime()->notNull());
	    $this->alterColumn('question', 'updated_at', $this->dateTime()->notNull());
	    $this->alterColumn('service', 'created_at', $this->dateTime()->notNull());
	    $this->alterColumn('service', 'updated_at', $this->dateTime()->notNull());
	    
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200122_133417_change_question_table cannot be reverted.\n";

        return false;
    }
}
