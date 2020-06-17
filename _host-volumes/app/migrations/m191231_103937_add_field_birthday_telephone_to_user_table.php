<?php

use yii\db\Migration;

/**
 * Class m191231_103937_add_field_birthday_telephone_to_user_table
 */
class m191231_103937_add_field_birthday_telephone_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->addColumn('user', 'birthday', $this->dateTime());
	    $this->addColumn('user', 'telephone', $this->string(256));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->dropColumn('user', 'birthday');
	    $this->dropColumn('user', 'telephone');
    }
}
