<?php
use yii\db\Schema;
use yii\db\Migration;

class m131219_135444_create_Object_table extends Migration
{
	public function up()
	{
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('Object', array(
            'id' => Schema::TYPE_PK,
            'Model' => Schema::TYPE_STRING . ' NOT NULL',
            'Model_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT,
            'required' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "0"',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ), $tableOptions);
	}

	public function down()
	{
		$this->dropTable('Object');
	}
}