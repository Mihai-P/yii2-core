<?php
use yii\db\Schema;
use yii\db\Migration;

class m140514_070052_alter_Menu_table extends Migration
{
	public function up()
	{
		$this->addColumn('Menu', 'rel', 'string DEFAULT NULL AFTER url');
		$this->addColumn('Menu', 'target', 'string DEFAULT NULL AFTER rel');
		
	}

	public function down()
	{
		$this->dropColumn('Menu', 'rel');
		$this->dropColumn('Menu', 'target');
	}
}