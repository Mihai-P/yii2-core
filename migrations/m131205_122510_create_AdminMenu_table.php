<?php
use yii\db\Schema;
use yii\db\Migration;

class m131205_122510_create_AdminMenu_table extends Migration
{
	public function up()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

		$this->createTable('AdminMenu', array(
            'id' => Schema::TYPE_PK,
            'AdminMenu_id' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'internal' => Schema::TYPE_STRING . ' NOT NULL',
            'url' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'ap' => Schema::TYPE_TEXT,
            'order' => Schema::TYPE_INTEGER . ' NOT NULL',
            'show_mobile' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "1"',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ), $tableOptions);
        $this->addForeignKey('AdminMenu_ibfk_1', 'AdminMenu', 'AdminMenu_id', 'AdminMenu', 'id', 'CASCADE', 'CASCADE');
        $this->execute('
INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(1, NULL, "Dashboard", "dashboard", "/", "", 1, "1");

INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(2, NULL, "Administrators", "Administrators", "/core/Administrator/admin/", "read::Administrator", 2, "1");
INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(3, 2, "Administrators", "AdministratorController", "/core/Administrator/admin/", "read::Administrator", 1, "0");
INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(4, 2, "Access Groups", "GroupController", "/core/Group/admin/", "read::Group", 2, "0");

INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(5, NULL, "Menus", "Menu", "/core/Menu/admin/", "read::Menu", 3, "0");
INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(6, 5, "Menus", "Menu", "/core/Menu/admin/", "read::Menu", 1, "0");
INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(7, 5, "Buttons", "Button", "/core/Button/admin/", "read::Button", 2, "0");


INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(8, NULL, "Pages", "PageController", "/core/Page/admin/", "read::Page", 4, "0");
INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(9, NULL, "Contacts", "ContactController", "/core/Contact/admin/", "read::Contact", 5, "1");
INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(10, NULL, "Tags", "TagController", "/core/Tag/admin/", "read::Tag", 6, "0");
INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(11, NULL, "Website", "WebsiteController", "/core/Website/update/id/1", "update::Website", 7, "0");
		');
	}

	public function down()
	{
		$this->dropTable('AdminMenu');
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