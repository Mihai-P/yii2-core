<?php
use yii\db\Schema;
use core\components\Migration;

class m131205_134345_create_Page_table extends Migration
{
    var $menu = 'Website';
    var $module = 'core';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('Page', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'url' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'h1' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'template' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'content' => Schema::TYPE_TEXT,
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $tableOptions);

        $this->createAuthItems();
        $this->createAdminMenu();        
    }

    public function down()
    {
        $this->dropTable('Page');
        $this->deleteAuthItems();
        $this->deleteAdminMenu();        
    }
}