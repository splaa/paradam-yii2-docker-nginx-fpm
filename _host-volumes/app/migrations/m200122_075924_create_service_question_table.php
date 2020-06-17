<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_question}}`.
 */
class m200122_075924_create_service_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_question}}', [
            'id' => $this->primaryKey(),
	        'created_at' => $this->integer(),
	        'updated_at' => $this->integer(),
	        's_question' => $this->string()->notNull(),
	        'status' => $this->smallInteger(3),
	        
	        
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_question}}');
    }
}
