<?php

use yii\db\Schema;
use yii\db\Migration;

class m141119_132507_update_AdminMenu_website extends Migration
{
    public function up()
    {
        $this->update('AdminMenu', ['url' => '/core/website/view?id=1', 'name' => 'Website'], ['internal' => 'WebsiteController']);
    }

    public function down()
    {
        echo "m141119_132507_update_AdminMenu_website cannot be reverted.\n";

        return false;
    }
}
