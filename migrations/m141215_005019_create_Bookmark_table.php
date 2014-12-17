<?php

use yii\db\Schema;
use core\components\Migration;

class m141215_005019_create_Bookmark_table extends Migration
{
    var $menu = 'Bookmark';
    var $singleMenu = true;
    var $module = 'core';
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('Bookmark', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'url' => Schema::TYPE_STRING . ' NOT NULL',
            'reminder' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'description' => Schema::TYPE_TEXT . ' DEFAULT NULL',
            'order' => Schema::TYPE_INTEGER . ' DEFAULT 1000',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $tableOptions);
        $this->addForeignKey('Bookmark_create_by', 'Bookmark', 'create_by', 'User', 'id', 'CASCADE', 'CASCADE');
        $this->createAuthItems();
        $this->createAdminMenu();
        $this->update('AdminMenu', ['icon' => 'fa-bookmark', 'name' => 'Bookmarks'], ['name' => 'Bookmark', 'AdminMenu_id' => null]);
    }

    public function down()
    {
        $this->dropForeignKey('Bookmark_create_by', 'Bookmark');
        $this->dropTable('Bookmark');
        $this->deleteAuthItems();
        $this->deleteAdminMenu();
    }
}
