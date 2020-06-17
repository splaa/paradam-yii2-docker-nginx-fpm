<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_question}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%service}}`
 * - `{{%question}}`
 */
class m200122_122324_create_junction_table_for_service_and_question_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_question}}', [
            'service_id' => $this->integer(),
            'question_id' => $this->integer(),
            'PRIMARY KEY(service_id, question_id)',
        ]);

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-service_question-service_id}}',
            '{{%service_question}}',
            'service_id'
        );

        // add foreign key for table `{{%service}}`
        $this->addForeignKey(
            '{{%fk-service_question-service_id}}',
            '{{%service_question}}',
            'service_id',
            '{{%service}}',
            'id',
            'CASCADE'
        );

        // creates index for column `question_id`
        $this->createIndex(
            '{{%idx-service_question-question_id}}',
            '{{%service_question}}',
            'question_id'
        );

        // add foreign key for table `{{%question}}`
        $this->addForeignKey(
            '{{%fk-service_question-question_id}}',
            '{{%service_question}}',
            'question_id',
            '{{%question}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%service}}`
        $this->dropForeignKey(
            '{{%fk-service_question-service_id}}',
            '{{%service_question}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-service_question-service_id}}',
            '{{%service_question}}'
        );

        // drops foreign key for table `{{%question}}`
        $this->dropForeignKey(
            '{{%fk-service_question-question_id}}',
            '{{%service_question}}'
        );

        // drops index for column `question_id`
        $this->dropIndex(
            '{{%idx-service_question-question_id}}',
            '{{%service_question}}'
        );

        $this->dropTable('{{%service_question}}');
    }
}
