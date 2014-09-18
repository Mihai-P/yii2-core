<?php

use yii\db\Schema;
use yii\db\Expression;

class m140629_123324_alter_Auth_Tables extends \yii\db\Migration
{
    public function up()
    {
    	$this->renameColumn('AuthAssignment', 'itemname', 'item_name');
    	$this->renameColumn('AuthAssignment', 'userid', 'user_id');
    	$this->addColumn('AuthAssignment', 'created_at', Schema::TYPE_INTEGER);

    	$this->addColumn('AuthItem', 'rule_name',  Schema::TYPE_STRING . '(64)');
    	$this->addColumn('AuthItem', 'created_at', Schema::TYPE_INTEGER);
    	$this->addColumn('AuthItem', 'updated_at', Schema::TYPE_INTEGER);

    	$this->update('AuthItem', ['type' => 1], ['type' => 2]);
    }

    public function down()
    {
        echo "m140629_123324_alter_Auth_Tables cannot be reverted.\n";
        return false;
    }
}
