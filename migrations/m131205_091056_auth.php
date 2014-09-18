<?php
use yii\db\Schema;
use yii\db\Migration;

class m131205_091056_auth extends Migration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }        

		$this->createTable('AuthItem',
	        array(
		            'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
		            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
		            'description' => 'text COLLATE utf8_bin',
	                'bizrule' => 'text COLLATE utf8_bin',
	                'data' => 'text COLLATE utf8_bin',
	                'PRIMARY KEY (`name`)', // primary item
	        ), $tableOptions);
		$this->createTable('AuthItemChild',
	        array(
		            'parent' => 'varchar(64) COLLATE utf8_bin NOT NULL',
		            'child' => 'varchar(64) COLLATE utf8_bin NOT NULL',
	                'PRIMARY KEY (`parent`,`child`)', // primary item
	        ), $tableOptions);
		$this->addForeignKey('AuthItemChild_ibfk_1', 'AuthItemChild', 'parent', 'AuthItem', 'name', 'CASCADE', 'CASCADE');
		$this->addForeignKey('AuthItemChild_ibfk_2', 'AuthItemChild', 'child', 'AuthItem', 'name', 'CASCADE', 'CASCADE');

		$this->createTable('AuthAssignment',
	        array(
		            'itemname' => 'varchar(64) COLLATE utf8_bin NOT NULL',
		            'userid' => 'varchar(64) COLLATE utf8_bin NOT NULL',
	                'bizrule' => 'text COLLATE utf8_bin',
	                'data' => 'text COLLATE utf8_bin',
	                'PRIMARY KEY (`itemname`,`userid`)', // primary item
	        ), $tableOptions);
	}

	public function safeDown()
	{
		$this->dropTable('AuthItemChild');
		$this->dropTable('AuthAssignment');
		$this->dropTable('AuthItem');
	}

}