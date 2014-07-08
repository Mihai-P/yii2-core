<?php
use yii\db\Schema;
use yii\db\Migration;

class m131205_113511_create_Website_table extends Migration
{
	public function up()
	{
		$this->createTable('Website', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'host' => 'string NOT NULL',
            'theme' => 'string NOT NULL',
            'status' => 'enum("active","inactive","deleted") NOT NULL DEFAULT "active"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
	    'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
	}

	public function down()
	{
		$this->dropTable('Website');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}