<?php

use yii\db\Schema;
use yii\db\Migration;

class m141119_124900_insert_auth_Website_read extends Migration
{
    public function up()
    {

        $this->insert('AuthItem', [
            "name" => 'read::Website',
            "type" => 0,
            "description" => 'read Website',
            "bizrule" => null,
            "data" => 'a:2:{s:6:"module";s:7:"Website";s:10:"controller";s:8:"Websites";}',
        ]);
        $this->insert('AuthItemChild', [
            "parent" => 1,
            "child" => 'read::Website',
        ]);
    }

    public function down()
    {
        echo "m141119_124900_insert_auth_Website_read cannot be reverted.\n";

        return false;
    }
}
