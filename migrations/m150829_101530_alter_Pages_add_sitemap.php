<?php

use yii\db\Schema;
use yii\db\Migration;

class m150829_101530_alter_Pages_add_sitemap extends Migration
{
    public function up()
    {
        $this->addColumn('Page', 'sitemap', 'enum("0","1") NOT NULL DEFAULT "0" AFTER content');
    }

    public function down()
    {
        $this->dropColumn('Page', 'sitemap');
    }
}
