<?php

use yii\db\Schema;
use yii\db\Migration;

class m141017_024247_alter_Menu_add_responsive extends Migration
{
    public function up()
    {
        $this->addColumn('Menu', 'responsive', Schema::TYPE_STRING . ' NOT NULL DEFAULT "" AFTER rel');
    }

    public function down()
    {
        echo "m141017_024247_alter_Menu_add_responsive cannot be reverted.\n";

        return false;
    }
}
