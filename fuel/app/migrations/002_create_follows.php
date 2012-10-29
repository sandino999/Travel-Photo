<?php

namespace Fuel\Migrations;

class Create_follows
{
	public function up()
	{
		\DBUtil::create_table('follows', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'useranem' => array('constraint' => 25, 'type' => 'varchar'),
			'follow' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('follows');
	}
}