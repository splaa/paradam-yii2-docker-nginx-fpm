<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%service}}`.
 */
class m200121_164332_add_updated_at_column_to_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->dropColumn('{{%service}}', 'created_at');
        $this->addColumn('{{%service}}', 'created_at', $this->integer()->notNull());
        $this->addColumn('{{%service}}', 'updated_at', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%service}}', 'created_at', $this->dateTime()->notNull());
        $this->dropColumn('{{%service}}', 'updated_at');
    }
}
