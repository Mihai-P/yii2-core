<?php
use yii\db\Schema;
use yii\db\Migration;

class m131205_134345_create_Page_table extends Migration
{
    public function up()
    {
        $this->createTable('Page', array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'url' => 'string DEFAULT NULL',
            'h1' => 'string DEFAULT NULL',
            'template' => 'string DEFAULT NULL',
            'content' => 'text',
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
        $this->dropTable('Page');
    }
}