<?php
use yii\db\Schema;
use yii\db\Migration;


class m131205_131516_create_Menu_table extends Migration
{
	public function up()
	{
		$this->createTable('Menu', array(
            'id' => 'pk',
            'Menu_id' => 'int(11) DEFAULT NULL',
            'name' => 'string NOT NULL',
            'internal' => 'string NOT NULL',
            'url' => 'string DEFAULT NULL',
            'ap' => 'text',
            'order' => 'int(11) NOT NULL',
            'root' => 'int(11) unsigned DEFAULT NULL',
            'lft' => 'int(11) unsigned NOT NULL',
            'rgt' => 'int(11) unsigned NOT NULL',
            'level' => 'int(11) unsigned NOT NULL',
            'status' => 'enum("active","inactive","deleted") NOT NULL DEFAULT "active"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
	    'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
        $this->addForeignKey('Menu_ibfk_1', 'Menu', 'Menu_id', 'Menu', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
        $this->dropTable('Menu');
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