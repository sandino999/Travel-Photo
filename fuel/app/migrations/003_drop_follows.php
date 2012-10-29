<?php

namespace Fuel\Migrations;

class Drop_follows
{
	public function up()
	{
		\DBUtil::drop_table('follows');
	}

	public function down()
	{
		\DBUtil::create_table('follows', array(
			'id' => array('type' => 'int', 'null' => true, 'constraint' => 11, 'auto_increment' => true),
			'useranem' => array('type' => 'varchar', 'null' => true, 'constraint' => 25),
			'follow' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'created_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),
			'updated_at' => array('type' => 'int', 'null' => true, 'constraint' => 11),

		), array('id'));

	}
}