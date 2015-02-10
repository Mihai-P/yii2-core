<?php

use yii\db\Schema;
use yii\db\Migration;

class m150210_214445_alter_Bookmark_table_url extends Migration
{
    public function up()
    {
        $this->alterColumn('Bookmark', 'url', Schema::TYPE_TEXT . ' NOT NULL');
    }

    public function down()
    {
        echo "m150210_214445_alter_Bookmark_table_url cannot be reverted.\n";

        return false;
    }
}
