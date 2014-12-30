<?php

use yii\db\Schema;
use yii\db\Migration;

class m141229_221228_create_Notification_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('Notification', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'description' => Schema::TYPE_TEXT . ' NOT NULL',
            'start_date' => Schema::TYPE_DATE . ' NULL',
            'end_date' => Schema::TYPE_DATE . ' NULL',
            'internal_type' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "Contact"',
            'type' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "info"',
            'all' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $tableOptions);

        $this->createTable('NotificationUser', [
            'id' => Schema::TYPE_PK,
            'Notification_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'User_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $tableOptions);
        $this->addForeignKey('NotificationUser_Notification_id', 'NotificationUser', 'Notification_id', 'Notification', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('NotificationUser_User_id', 'NotificationUser', 'User_id', 'User', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('NotificationRead', [
            'id' => Schema::TYPE_PK,
            'Notification_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'User_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ], $tableOptions);
        $this->addForeignKey('NotificationRead_Notification_id', 'NotificationRead', 'Notification_id', 'Notification', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('NotificationRead_User_id', 'NotificationRead', 'User_id', 'User', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('NotificationRead_Notification_id', 'NotificationRead');
        $this->dropForeignKey('NotificationRead_User_id', 'NotificationRead');
        $this->dropTable('NotificationRead');

        $this->dropForeignKey('NotificationUser_Notification_id', 'NotificationUser');
        $this->dropForeignKey('NotificationUser_User_id', 'NotificationUser');
        $this->dropTable('NotificationUser');

        $this->dropTable('Notification');

    }
}
