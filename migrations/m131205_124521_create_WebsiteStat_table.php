<?php
use yii\db\Schema;
use yii\db\Migration;

class m131205_124521_create_WebsiteStat_table extends Migration
{
	public function up()
	{
		$this->createTable('WebsiteStat', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'pageviews' => 'int(10) unsigned NOT NULL DEFAULT "0"',
            'visitors' => 'int(10) unsigned NOT NULL DEFAULT "0"',
            'visits' => 'int(10) unsigned NOT NULL DEFAULT "0"',
            'newvisits' => 'int(10) unsigned NOT NULL DEFAULT "0"',
            'theme' => 'string NOT NULL',
            'status' => 'enum("active","inactive","deleted") NOT NULL DEFAULT "active"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
	    'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->execute('
			INSERT INTO `WebsiteStat` (`name`, `pageviews`, `visitors`, `visits`, `newvisits`) VALUES (CURRENT_DATE(), "0", "0", "0", "0");
		');
	}

	public function down()
	{
		$this->dropTable('WebsiteStat');
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