<?php
use yii\db\Schema;
use yii\db\Migration;

class m131219_135444_create_Object_table extends Migration
{
	public function up()
	{
        $this->createTable('Object', array(
            'id' => 'pk',
            'Model' => 'string NOT NULL',
            'Model_id' => 'int(11) NOT NULL',
            'name' => 'string NOT NULL',
            'content' => 'text default ""',
            'required' => 'enum("0","1") NOT NULL DEFAULT "0"',
            'status' => 'enum("active","inactive","deleted") NOT NULL DEFAULT "active"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
        'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');		
	}

	public function down()
	{
		$this->dropTable('Object');
	}
}