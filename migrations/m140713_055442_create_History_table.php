<?php

use yii\db\Schema;
use yii\db\Migration;

class m140713_055442_create_History_table extends Migration
{
    public function up()
    {
        $this->createTable('History', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'url' => 'string NOT NULL',
            'status' => 'enum("active","deleted") NOT NULL DEFAULT "active"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
        'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');	
		$this->addForeignKey('History_create_by', 'History', 'create_by', 'User', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
		$this->dropForeignKey('History_create_by', 'History');
		$this->dropTable('History');
    }
}
