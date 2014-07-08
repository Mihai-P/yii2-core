<?php
use yii\db\Schema;
use yii\db\Migration;

class m131207_234948_create_Email_table extends Migration
{
	public function up()
	{
        $this->createTable('Email', array(
            'id' => 'pk',
            'from_email' => 'string NOT NULL',
            'from_name' => 'string NOT NULL',
            'to_email' => 'string NOT NULL',
            'to_name' => 'string NOT NULL',
            'subject' => 'string DEFAULT ""',
            'text' => 'text',
            'html' => 'text',
            'route' => 'enum("mandrill","mailchimp") NOT NULL DEFAULT "mandrill"',
            'tries' => 'int(2) NOT NULL DEFAULT 0',
            'status' => 'enum("pending","sent","failed","deleted") NOT NULL DEFAULT "pending"',
            'update_time' => 'datetime DEFAULT NULL',
            'update_by' => 'int(11) DEFAULT NULL',
            'create_time' => 'datetime DEFAULT NULL',
            'create_by' => 'int(11) DEFAULT NULL',
        ),
        'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');		
	}

	public function down()
	{
		$this->dropTable('Email');
	}
}