<?php

use yii\db\Migration;

/**
 * Class m191226_132524_create_connect_language_description
 */
class m191226_132524_create_connect_language_description extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->addForeignKey(
		    'fk-product_description-id_language',
		    'product_description',
		    'id_language',
		    'language',
		    'id',
		    'CASCADE'
	    );
	    $this->addForeignKey(
		    'fk-content_type_description-id_language',
		    'content_type_description',
		    'id_language',
		    'language',
		    'id',
		    'CASCADE'
	    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->dropForeignKey(
		    'fk-product_description-id_language',
		    'product_description'
	    );

	    $this->dropForeignKey(
		    'fk-content_type_description-id_language',
		    'content_type_description'
	    );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191226_132524_create_connect_language_description cannot be reverted.\n";

        return false;
    }
    */
}
