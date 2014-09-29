<?php
use yii\db\Schema;
use core\components\Migration;

class m131206_222244_create_Tag_table extends Migration
{
    var $singleMenu = true;
    var $module = 'core';
    var $menu = 'Tags';

	public function up()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
                
        $this->createTable('Tag', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'type' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $tableOptions);
        $this->createIndex('Tag_type', 'Tag', 'type');

        $this->createAuthItems();
        $this->createAdminMenu();                
	}

	public function down()
	{
        $this->dropIndex('Tag_type', 'Tag');
		$this->dropTable('Tag');
        $this->deleteAuthItems();
        $this->deleteAdminMenu();             
	}
}