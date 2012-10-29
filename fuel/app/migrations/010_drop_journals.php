<?php

namespace Fuel\Migrations;

class Drop_journals
{
	public function up()
	{
		\DBUtil::drop_table('journals');
	}

	public function down()
	{
		\DBUtil::create_table('journals', array(
			'id' => array('type' => 'int', 'null' => true, 'constraint' => 11, 'auto_increment' => true),
			'name' => array('type' => 'varchar', 'null' => true, 'constraint' => 25),
			'user' => array('type' => 'varchar', 'null' => true, 'constraint' => 25),
			'datein' => array('type' => 'date', 'null' => true),
			'dateout' => array('type' => 'date', 'null' => true),
			'description' => array('type' => 'text', 'null' => true),
			'photo' => array('type' => 'varchar', 'null' => true, 'constraint' => 255),
			'created_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'updated_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),

		), array('id'));

	}
}