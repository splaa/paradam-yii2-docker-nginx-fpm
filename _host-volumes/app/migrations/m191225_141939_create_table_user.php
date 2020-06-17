<?php

use yii\db\Migration;

/**
 * Class m191225_141939_create_table_user
 */
class m191225_141939_create_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
			if ($this->db->driverName === 'mysql') {
				$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
			}

			$this->createTable('{{%user}}', [
				'id' => $this->primaryKey(),
				'created_at' => $this->integer()->notNull(),
				'updated_at' => $this->integer()->notNull(),
				'username' => $this->string()->notNull(),
				'auth_key' => $this->string(32),
				'email_confirm_token' => $this->string(),
				'password_hash' => $this->string()->notNull(),
				'password_reset_token' => $this->string(),
				'email' => $this->string()->notNull(),
				'status' => $this->smallInteger()->notNull()->defaultValue(0),
			], $tableOptions);

			$this->createIndex('idx-user-username', '{{%user}}', 'username');
			$this->createIndex('idx-user-email', '{{%user}}', 'email');
			$this->createIndex('idx-user-status', '{{%user}}', 'status');
		}

		/**
		 * {@inheritdoc}
		 */
		public function safeDown()
		{
			$this->dropTable('{{%user}}');
		}
	}