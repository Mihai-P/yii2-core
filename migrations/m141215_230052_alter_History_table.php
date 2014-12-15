<?php

use yii\db\Schema;
use yii\db\Migration;

class m141215_230052_alter_History_table extends Migration
{
    public function up()
    {
        $this->addColumn('History', 'type', Schema::TYPE_STRING . ' NOT NULL AFTER name');
    }

    public function down()
    {
        $this->dropColumn('History', 'type');
    }
}
