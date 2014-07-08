<?php
use yii\db\Schema;
use yii\db\Migration;

class m131206_222244_create_Tag_table extends Migration
{
	public function up()
	{
        $this->createTable('Tag', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'type' => 'string NOT NULL',
            'status' => 'enum("active","inactive","deleted") NOT NULL DEFAULT "active"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
        'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
        $this->createIndex('idx_type','Tag', 'type');
	}

	public function down()
	{
		$this->dropTable('Tag');
	}
}