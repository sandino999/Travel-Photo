<?php

namespace Fuel\Migrations;

class Create_users
{
	public function up()
	{
		\DBUtil::create_table('users', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'user' => array('constraint' => 25, 'type' => 'varchar'),
			'pass' => array('constraint' => 255, 'type' => 'varchar'),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'photo' => array('constraint' => 25, 'type' => 'varchar'),
			'email' => array('constraint' => 30, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('users');
	}
}