<?php

use yii\db\Schema;
use core\models\AdminMenu;
use core\components\Migration;

class m140822_021737_create_PageTemplate_table extends Migration
{
	var $menu = 'Website';
    var $module = 'core';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('PageTemplate', array(
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'template' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ), $tableOptions);

        $this->insert('PageTemplate', [
                'name' => 'Main',
                'template' => "main.php",
        ]);

        $this->addColumn('Page', 'PageTemplate_id', 'int(11) NOT NULL DEFAULT "1" AFTER name');
        $this->addForeignKey('Page_PageTemplate_id', 'Page', 'PageTemplate_id', 'PageTemplate', 'id', 'CASCADE', 'CASCADE');

        $this->createAuthItems();
        $this->createAdminMenu();
        $this->update('AdminMenu', [
			'order' => 4,
		], ['internal' => 'WebsiteController']);
        $this->update('AdminMenu', [
            'order' => 3,
        ], ['internal' => 'PageTempalteController']);
    }

    public function down()
    {
    	$this->dropForeignKey('Page_PageTemplate_id', 'User');
    	$this->dropColumn('Page', 'PageTemplate_id');
    	$this->dropTable('PageTemplate');

		$this->delete('AdminMenu', ['internal' => 'PageController']);
		$this->delete('AdminMenu', ['internal' => 'PageTemplateController']);

		$this->deleteAuthItems();
		$this->deleteAdminMenu();
    }
}