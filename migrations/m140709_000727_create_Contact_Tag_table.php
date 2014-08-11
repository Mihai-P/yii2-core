<?php

use yii\db\Schema;
use yii\db\Migration;

class m140709_000727_create_Contact_Tag_table extends Migration
{
    public function up()
    {
        $this->createTable('Contact_Tag', array(
            'id' => 'pk',
            'Tag_id' => 'int(11) NOT NULL',
            'Contact_id' => 'int(11) NOT NULL',
            'status' => 'enum("active","inactive","deleted") NOT NULL DEFAULT "active"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
        'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
        $this->addForeignKey('Contact_Tag_Tag_id', 'Contact_Tag', 'Tag_id', 'Tag', 'id', 'CASCADE', 'CASCADE');        
        $this->addForeignKey('Contact_Tag_Contact_id', 'Contact_Tag', 'Contact_id', 'User', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
    	$this->dropTable('Contact_Tag');
    }
}
