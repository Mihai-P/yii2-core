<?php
use yii\db\Schema;
use core\components\Migration;

class m131205_113511_create_Website_table extends Migration
{
	var $module = 'core';
	var $privileges = ['update'];
	var $menu = 'Website';

	public function up()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        
		$this->createTable('Website', array(
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'host' => Schema::TYPE_STRING . ' NOT NULL',
            'theme' => Schema::TYPE_STRING . ' NOT NULL',
            'template' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ), $tableOptions);
        
        $this->insert('Website', [
            'name' => 'Default',
            'host' => 'default',
            'theme' => 'default',
            'template' => '@core/views/website/default',
        ]);

        $this->createAuthItems();
        $this->createAdminMenu();
        $this->update('AdminMenu', ['ap' => 'update::Website'], ['internal' => 'Website']);
        $this->update('AdminMenu', ['ap' => 'update::Website', 'url' => '/core/website/update?id=1'], ['internal' => 'WebsiteController']);
	}

	public function down()
	{
		$this->dropTable('Website');
        $this->deleteAuthItems();
        $this->deleteAdminMenu();
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