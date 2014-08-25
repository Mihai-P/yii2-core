<?php

use yii\db\Schema;
use core\models\AdminMenu;
use core\components\Migration;

class m140822_021737_create_PageTemplate_table extends Migration
{
	var $menu = 'Pages';

    public function up()
    {
        $this->createTable('PageTemplate', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'template' => 'string DEFAULT NULL',
            'status' => 'enum("active","inactive","deleted") NOT NULL DEFAULT "active"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
        'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

        $this->insert('PageTemplate', [
                'name' => 'Main',
                'template' => "main.php",
        ]);

        $this->addColumn('Page', 'PageTemplate_id', 'int(11) NOT NULL DEFAULT "1" AFTER name');
        $this->addForeignKey('Page_PageTemplate_id', 'Page', 'PageTemplate_id', 'PageTemplate', 'id', 'CASCADE', 'CASCADE');

		$page_menu = AdminMenu::find()->where(['internal' => 'PageController'])->one();
		$page_menu->url = '';
		$page_menu->internal = 'Pages';
		$page_menu->save();

        $this->insert('AdminMenu', [
        	'AdminMenu_id' => $page_menu->id, 
        	'name' => 'Pages', 
        	'internal' => 'PageController', 
        	'url' => '/core/Page/admin/', 
        	'ap' => 'read::Page', 
        	'order' => '1'
        ]);
        $this->createAuthItems();
        $this->createAdminMenu();
        $this->update('AdminMenu', [
			'name' => 'Templates',
		], ['internal' => 'PageTemplateController']);
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

		$this->update('AdminMenu', [
			'url' => '/core/Page/admin/',
			'internal' => 'PageController'
		], ['internal' => 'Pages']);

    }
}
