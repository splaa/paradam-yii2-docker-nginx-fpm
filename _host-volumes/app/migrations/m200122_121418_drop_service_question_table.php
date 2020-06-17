<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%service_question}}`.
 */
class m200122_121418_drop_service_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%service_question}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%service_question}}', [
            'id' => $this->primaryKey(),
        ]);
    }
}
