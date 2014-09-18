<?php
use yii\db\Schema;
use core\components\Migration;

class m131205_091157_create_Group_table extends Migration
{
	var $menu = 'Administrators';
    var $module = 'core';

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }        

		$this->createTable('Group', [
		            'id' => Schema::TYPE_PK,
		            'name' => Schema::TYPE_STRING . '',
		            'status' => Schema::TYPE_STRING . ' DEFAULT "active"',
		            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
		            'update_by' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
		            'create_by' => Schema::TYPE_STRING . ' DEFAULT NULL',
	        ], $tableOptions);
		$this->execute('
			INSERT INTO `Group` (`id`, `name`, `status`, `update_time`, `update_by`, `create_time`, `create_by`) VALUES
			(1, "Super Admin", "active", NULL, NULL, NULL, NULL);');
		$this->execute('INSERT INTO `AuthItem` VALUES("1", 2, "", NULL, "N;");');

 		$this->insert('AuthAssignment', [
                'itemname' => "1",
                'userid' => "1",
                'bizrule' => NULL,
                'data' => NULL
        ]);

        $this->createAuthItems();
        $this->createAdminMenu();        
	}

	public function safeDown()
	{
		$this->dropTable('Group');

        $this->deleteAuthItems();
        $this->deleteAdminMenu();  		
	}

}