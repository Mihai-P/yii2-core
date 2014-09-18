<?php
use yii\db\Schema;
use yii\db\Migration;

class m131205_124521_create_WebsiteStat_table extends Migration
{
	public function up()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

		$this->createTable('WebsiteStat', array(
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'pageviews' => Schema::TYPE_INTEGER . ' unsigned NOT NULL DEFAULT "0"',
            'visitors' => Schema::TYPE_INTEGER . ' unsigned NOT NULL DEFAULT "0"',
            'visits' => Schema::TYPE_INTEGER . ' unsigned NOT NULL DEFAULT "0"',
            'newvisits' => Schema::TYPE_INTEGER . ' unsigned NOT NULL DEFAULT "0"',
            'theme' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ), $tableOptions);

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