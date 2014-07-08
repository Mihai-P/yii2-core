<?php
use yii\db\Schema;
use yii\db\Migration;

class m140514_070052_alter_Menu_table extends Migration
{
	public function up()
	{
		$this->addColumn('Menu', 'rel', 'enum("alternate","author","bookmark","help","license","next","nofollow","noreferrer","prefetch","prev","search","tag") DEFAULT NULL AFTER url');
		$this->addColumn('Menu', 'target', 'enum("_blank","_parent","_self","_top") DEFAULT NULL AFTER rel');
		
	}

	public function down()
	{
		$this->dropColumn('Menu', 'rel');
		$this->dropColumn('Menu', 'target');
	}
}