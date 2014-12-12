<?php

use yii\db\Schema;
use yii\db\Migration;

class m141212_222648_alter_AdminMenu_icon extends Migration
{
    public function up()
    {
        $this->addColumn('AdminMenu', 'icon', Schema::TYPE_STRING . ' NULL DEFAULT NULL AFTER name');
        $this->update('AdminMenu', ['icon' => 'fa-user'], ['name' => 'Contacts', 'AdminMenu_id' => null]);
        $this->update('AdminMenu', ['icon' => 'fa-tags'], ['name' => 'Tags', 'AdminMenu_id' => null]);
        $this->update('AdminMenu', ['icon' => 'fa-laptop'], ['name' => 'Dashboard', 'AdminMenu_id' => null]);
        $this->update('AdminMenu', ['icon' => 'fa-group'], ['name' => 'Administrators', 'AdminMenu_id' => null]);
        $this->update('AdminMenu', ['icon' => 'fa-desktop'], ['name' => 'Website', 'AdminMenu_id' => null]);

    }

    public function down()
    {
        $this->dropColumn('AdminMenu', 'icon');
    }
}
