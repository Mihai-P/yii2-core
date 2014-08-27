<?php

use yii\db\Schema;
use yii\db\Migration;

class m140826_133528_create_Session_table extends Migration
{
    public function up()
    {
        $this->createTable('Session', array(
            'id' => 'CHAR(40) NOT NULL PRIMARY KEY',
            'expire' => 'INTEGER',
            'data' => 'LONGBLOB',
        ),
        'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
    }

    public function down()
    {
    	$this->dropTable('Session');
    }
}
