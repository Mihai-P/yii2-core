<?php
use yii\db\Schema;
use core\components\Migration;

class m131205_131516_create_Menu_table extends Migration
{
    var $menu = 'Website';
    var $module = 'core';

	public function up()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

		$this->createTable('Menu', [
            'id' => Schema::TYPE_PK,
            'Menu_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'internal' => Schema::TYPE_STRING . ' NOT NULL',
            'url' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'rel' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'target' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'ap' => Schema::TYPE_TEXT,
            'order' => Schema::TYPE_INTEGER . ' NOT NULL',
            'root' => Schema::TYPE_INTEGER . ' unsigned DEFAULT NULL',
            'lft' => Schema::TYPE_INTEGER . ' unsigned NOT NULL',
            'rgt' => Schema::TYPE_INTEGER . ' unsigned NOT NULL',
            'level' => Schema::TYPE_INTEGER . ' unsigned NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $tableOptions);
        $this->addForeignKey('Menu_Menu_id', 'Menu', 'Menu_id', 'Menu', 'id', 'CASCADE', 'CASCADE');

        $this->createAuthItems();
        $this->createAdminMenu();
	}

	public function down()
	{
        $this->dropForeignKey('Menu_Menu_id', 'Menu');
        $this->dropTable('Menu');

        $this->deleteAuthItems();
        $this->deleteAdminMenu();        
	}
}