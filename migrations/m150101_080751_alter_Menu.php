<?php

use yii\db\Schema;
use yii\db\Migration;

class m150101_080751_alter_Menu extends Migration
{
    public function up()
    {
        $this->renameColumn('Menu', 'level', 'depth');
    }

    public function down()
    {
        echo "m150101_080751_alter_Menu cannot be reverted.\n";

        return false;
    }
}
