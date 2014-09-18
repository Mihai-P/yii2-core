<?php
use yii\db\Schema;
use yii\db\Migration;

class m131207_234948_create_Email_table extends Migration
{
	public function up()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('Email', array(
            'id' => Schema::TYPE_PK,
            'from_email' => Schema::TYPE_STRING . ' NOT NULL',
            'from_name' => Schema::TYPE_STRING . ' NOT NULL',
            'to_email' => Schema::TYPE_STRING . ' NOT NULL',
            'to_name' => Schema::TYPE_STRING . ' NOT NULL',
            'reply_to' => Schema::TYPE_STRING . ' NULL',
            'subject' => Schema::TYPE_STRING . ' DEFAULT ""',
            'text' => Schema::TYPE_TEXT,
            'html' => Schema::TYPE_TEXT,
            'route' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "mandrill"',
            'tries' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "pending"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ), $tableOptions);
	}

	public function down()
	{
		$this->dropTable('Email');
	}
}