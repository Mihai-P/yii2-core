<?php

use yii\db\Schema;
use yii\db\Migration;

class m140831_093732_create_audit_trail extends Migration
{
	/**
	 * Creates initial version of the audit trail table
	 */
	public function up()
	{
		//Create our first version of the audittrail table	
		//Please note that this matches the original creation of the 
		//table from version 1 of the extension. Other migrations will
		//upgrade it from here if we ever need to. This was done so
		//that older versions can still use migrate functionality to upgrade.
		$this->createTable( 'audit_trail', [
				'id' => Schema::TYPE_PK,
				'old_value' => Schema::TYPE_TEXT,
				'new_value' => Schema::TYPE_TEXT,
				'action' => Schema::TYPE_STRING . ' NOT NULL',
				'model' => Schema::TYPE_STRING . ' NOT NULL',
				'field' => Schema::TYPE_STRING . '',
				'stamp' => Schema::TYPE_DATETIME . ' NOT NULL',
				'user_id' => Schema::TYPE_STRING . '',
				'model_id' => Schema::TYPE_STRING . ' NOT NULL',
			]
		);

		//Index these bad boys for speedy lookups
		$this->createIndex( 'idx_audit_trail_user_id', 'audit_trail', 'user_id');
		$this->createIndex( 'idx_audit_trail_model_id', 'audit_trail', 'model_id');
		$this->createIndex( 'idx_audit_trail_model', 'audit_trail', 'model');
		$this->createIndex( 'idx_audit_trail_field', 'audit_trail', 'field');
		/* http://stackoverflow.com/a/1827099/383478
		$this->createIndex( 'idx_audit_trail_old_value', 'tbl_audit_trail', 'old_value');
		$this->createIndex( 'idx_audit_trail_new_value', 'tbl_audit_trail', 'new_value');
		*/
		$this->createIndex( 'idx_audit_trail_action', 'audit_trail', 'action');
	}

	/**
	 * Drops the audit trail table
	 */
	public function down()
	{
		$this->dropTable( 'audit_trail' );
	}

	/**
	 * Creates initial version of the audit trail table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drops the audit trail table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}