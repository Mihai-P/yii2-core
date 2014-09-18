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

		$this->execute('INSERT INTO `AuthItem` VALUES("create::AdminMenu", 0, "create AdminMenu", NULL, \'a:2:{s:6:"module";s:14:"Administration";s:10:"controller";s:9:"AdminMenu";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("create::Button", 0, "create Button", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:6:"Button";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("create::Contact", 0, "create Contact", NULL, \'a:2:{s:6:"module";s:7:"Contact";s:10:"controller";s:7:"Contact";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("create::Group", 0, "create Group", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:5:"Group";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("create::Menu", 0, "create Menu", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:4:"Menu";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("create::Page", 0, "create Page", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:4:"Page";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("create::Tag", 0, "create Tag", NULL, \'a:2:{s:6:"module";s:4:"Misc";s:10:"controller";s:3:"Tag";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("create::Administrator", 0, "create User", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:13:"Administrator";}\');');


		$this->execute('INSERT INTO `AuthItem` VALUES("delete::AdminMenu", 0, "delete AdminMenu", NULL, \'a:2:{s:6:"module";s:14:"Administration";s:10:"controller";s:9:"AdminMenu";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("delete::Button", 0, "delete Button", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:6:"Button";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("delete::Contact", 0, "delete Contact", NULL, \'a:2:{s:6:"module";s:7:"Contact";s:10:"controller";s:7:"Contact";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("delete::Group", 0, "delete Group", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:5:"Group";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("delete::Menu", 0, "delete Menu", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:4:"Menu";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("delete::Page", 0, "delete Page", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:4:"Page";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("delete::Tag", 0, "delete Tag", NULL, \'a:2:{s:6:"module";s:4:"Misc";s:10:"controller";s:3:"Tag";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("delete::Administrator", 0, "delete User", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:13:"Administrator";}\');');


		$this->execute('INSERT INTO `AuthItem` VALUES("read::AdminMenu", 0, "read AdminMenu", NULL, \'a:2:{s:6:"module";s:14:"Administration";s:10:"controller";s:9:"AdminMenu";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("read::Button", 0, "read Button", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:6:"Button";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("read::Contact", 0, "read Contact", NULL, \'a:2:{s:6:"module";s:7:"Contact";s:10:"controller";s:7:"Contact";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("read::Group", 0, "read Group", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:5:"Group";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("read::Menu", 0, "read Menu", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:4:"Menu";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("read::Page", 0, "read Page", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:4:"Page";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("read::Tag", 0, "read Tag", NULL, \'a:2:{s:6:"module";s:4:"Misc";s:10:"controller";s:3:"Tag";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("read::Administrator", 0, "read User", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:13:"Administrator";}\');');


		$this->execute('INSERT INTO `AuthItem` VALUES("update::AdminMenu", 0, "update AdminMenu", NULL, \'a:2:{s:6:"module";s:14:"Administration";s:10:"controller";s:9:"AdminMenu";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update::Button", 0, "update Button",  NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:6:"Button";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update::Contact", 0, "update Contact", NULL, \'a:2:{s:6:"module";s:7:"Contact";s:10:"controller";s:7:"Contact";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update::Group", 0, "update Group", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:5:"Group";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update::Menu", 0, "update Menu", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:4:"Menu";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update::Page", 0, "update Page", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:4:"Page";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update::Tag", 0, "update Tag", NULL, \'a:2:{s:6:"module";s:4:"Misc";s:10:"controller";s:3:"Tag";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update::Administrator", 0, "update User", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:13:"Administrator";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update own::Administrator", 1, "update own User", NULL, \'a:2:{s:6:"module";s:13:"Administrator";s:10:"controller";s:13:"Administrator";}\');');
		$this->execute('INSERT INTO `AuthItem` VALUES("update::Website", 0, "update Website", NULL, \'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:7:"Website";}\');');

		$this->createTable('Group',
	        array(
		            'id' => Schema::TYPE_PK,
		            'name' => Schema::TYPE_STRING . '',
		            'status' => Schema::TYPE_STRING . ' DEFAULT "active"',
		            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
		            'update_by' => Schema::TYPE_STRING . ' DEFAULT NULL',
		            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
		            'create_by' => Schema::TYPE_STRING . ' DEFAULT NULL',
	        ), $tableOptions);
		$this->execute('
			INSERT INTO `Group` (`id`, `name`, `status`, `update_time`, `update_by`, `create_time`, `create_by`) VALUES
			(1, "Admin", "active", NULL, NULL, NULL, NULL);');
		$this->execute('INSERT INTO `AuthItem` VALUES("1", 2, "", NULL, "N;");');

		$this->execute('
			INSERT INTO `AuthItemChild` (`parent`, `child`) VALUES
				("1", "create::AdminMenu"),
				("1", "create::Button"),
				("1", "create::Contact"),
				("1", "create::Group"),
				("1", "create::Menu"),
				("1", "create::Page"),
				("1", "create::Tag"),
				("1", "create::Administrator"),
				("1", "delete::AdminMenu"),
				("1", "delete::Button"),
				("1", "delete::Contact"),
				("1", "delete::Group"),
				("1", "delete::Menu"),
				("1", "delete::Page"),
				("1", "delete::Tag"),
				("1", "delete::Administrator"),
				("1", "read::AdminMenu"),
				("1", "read::Button"),
				("1", "read::Contact"),
				("1", "read::Group"),
				("1", "read::Menu"),
				("1", "read::Page"),
				("1", "read::Tag"),
				("1", "read::Administrator"),
				("1", "update own::Administrator"),
				("1", "update::AdminMenu"),
				("1", "update::Button"),
				("1", "update::Contact"),
				("1", "update::Group"),
				("1", "update::Menu"),
				("1", "update::Page"),
				("1", "update::Tag"),
				("1", "update::Website"),
				("1", "update::Administrator");');

		$this->createTable('User',
	        array(
		            'id' => Schema::TYPE_PK,
		            'Group_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
		            'username' => Schema::TYPE_STRING . ' DEFAULT NULL',
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
	        ), $tableOptions);
		
		$this->addForeignKey('User_Group_id', 'User', 'Group_id', 'Group', 'id', 'CASCADE', 'SET NULL');

        $this->insert('User', [
                'id' => 1,
                'Group_id' => 1,
                'type' => "Administrator",
                'username' => "admin",
                'password' => Yii::$app->getSecurity()->generatePasswordHash("admin"),
                'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
                'name' => 'Firstname Lastname',
                'firstname' => 'Firstname',
                'lastname' => 'Lastname',
                'email' => 'webmaster@2ezweb.com.au',
        ]);

 		$this->insert('AuthAssignment', [
                'itemname' => "1",
                'userid' => "1",
                'bizrule' => NULL,
                'data' => NULL
        ]);		
	}

	public function safeDown()
	{
		$this->dropTable('User');
		$this->dropTable('AuthItemChild');
		$this->dropTable('AuthAssignment');
		$this->dropTable('Group');
		$this->dropTable('AuthItem');
	}

}