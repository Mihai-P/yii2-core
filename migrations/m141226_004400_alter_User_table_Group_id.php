<?php

use yii\db\Schema;
use yii\db\Migration;

class m141226_004400_alter_User_table_Group_id extends Migration
{
    public function up()
    {
        $this->dropForeignKey('User_Group_id', 'User');
        $this->addForeignKey('User_Group_id', 'User', 'Group_id', 'Group', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        echo "m141226_004400_alter_User_table_Group_id cannot be reverted.\n";

        return false;
    }
}
