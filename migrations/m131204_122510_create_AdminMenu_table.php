<?php
use yii\db\Schema;
use yii\db\Migration;

class m131204_122510_create_AdminMenu_table extends Migration
{
	public function up()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

		$this->createTable('AdminMenu', [
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
        ], $tableOptions);
        $this->addForeignKey('AdminMenu_ibfk_1', 'AdminMenu', 'AdminMenu_id', 'AdminMenu', 'id', 'CASCADE', 'CASCADE');
        $this->execute('
		INSERT INTO `AdminMenu` (`id`, `AdminMenu_id`, `name`, `internal`, `url`, `ap`, `order`, `show_mobile`) VALUES(1, NULL, "Dashboard", "dashboard", "/", "", 1, "1");
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