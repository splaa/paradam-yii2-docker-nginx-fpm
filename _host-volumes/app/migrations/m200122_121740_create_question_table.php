<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 */
class m200122_121740_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
	        'created_at' => $this->integer(),
	        'updated_at' => $this->integer(),
	        'question' => $this->string()->notNull(),
	        'status' => $this->smallInteger(3),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%question}}');
    }
}
