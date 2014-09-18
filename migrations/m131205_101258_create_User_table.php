<?php
use yii\db\Schema;
use core\components\Migration;

class m131205_101258_create_User_table extends Migration
{
	var $module = 'core';
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }        

		$this->createTable('User', [
		            'id' => Schema::TYPE_PK,
		            'Group_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
		            'type' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "Contact"',
		            'password' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'password_reset_token' => Schema::TYPE_STRING . '(32)',
		            'auth_key' => Schema::TYPE_STRING . '(128)',
		            'name' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'firstname' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'lastname' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'picture' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'email' => Schema::TYPE_STRING . ' NOT NULL',
		            'phone' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'mobile' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'validation_key' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'login_attempts' => 'int(10) NOT NULL DEFAULT "0"',
		            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
		            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
		            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
		            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
		            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
	        ], $tableOptions);
		
		$this->addForeignKey('User_Group_id', 'User', 'Group_id', 'Group', 'id', 'CASCADE', 'SET NULL');

        $this->insert('User', [
                'id' => 1,
                'Group_id' => 1,
                'type' => "Administrator",
                'password' => Yii::$app->getSecurity()->generatePasswordHash("admin"),
                'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
                'name' => 'Firstname Lastname',
                'firstname' => 'Firstname',
                'lastname' => 'Lastname',
                'email' => 'webmaster@2ezweb.com.au',
        ]);

        $this->menu = 'Administrators'; $this->controller = 'Administrator'; $this->privileges = ['create', 'delete', 'read', 'update', 'update own'];
        $this->createAuthItems();
        $this->createAdminMenu();

        $this->menu = 'Contacts'; $this->controller = 'Contact'; $this->singleMenu = true; $this->privileges = ['create', 'delete', 'read', 'update'];
        $this->createAuthItems();
        $this->createAdminMenu();

	}

	public function safeDown()
	{
		$this->dropForeignKey('User_Group_id', 'User');
		$this->dropTable('User');
	}

}