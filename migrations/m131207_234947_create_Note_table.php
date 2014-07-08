<?php
use yii\db\Schema;
use yii\db\Migration;

class m131207_234947_create_Note_table extends Migration
{
	public function up()
	{
        $this->createTable('Note', array(
            'id' => 'pk',
            'Model' => 'string NOT NULL',
            'Model_id' => 'int(11) NOT NULL',
            'description' => 'text',
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
		$this->dropTable('Note');
	}
}