<?php

use yii\db\Schema;
use yii\db\Migration;

class m140709_000727_create_Contact_Tag_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('Contact_Tag', array(
            'id' => Schema::TYPE_PK,
            'Tag_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'Contact_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "active"',
            'update_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'update_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'create_time' => Schema::TYPE_DATETIME . ' DEFAULT NULL',
            'create_by' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
        ), $tableOptions);

        $this->addForeignKey('Contact_Tag_Tag_id', 'Contact_Tag', 'Tag_id', 'Tag', 'id', 'CASCADE', 'CASCADE');        
        $this->addForeignKey('Contact_Tag_Contact_id', 'Contact_Tag', 'Contact_id', 'User', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('Contact_Tag_unique', 'Contact_Tag', ['Tag_id', 'Contact_id', 'status'], true);
    }

    public function down()
    {
        $this->dropIndex('Contact_Tag_unique', 'Contact_Tag');
        $this->dropForeignKey('Contact_Tag_Tag_id', 'Contact_Tag');
        $this->dropForeignKey('Contact_Tag_Contact_id', 'Contact_Tag');
    	$this->dropTable('Contact_Tag');
    }
}
