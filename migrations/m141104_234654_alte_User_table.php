<?php

use yii\db\Schema;
use yii\db\Migration;

class m141104_234654_alte_User_table extends Migration
{
    public function up()
    {
        $this->alterColumn('User', 'password_reset_token', Schema::TYPE_STRING . '(64)');

    }

    public function down()
    {
        echo "m141104_234654_alte_User_table cannot be reverted.\n";

        return false;
    }
}
