<?php

namespace Fuel\Migrations;

class Create_journals
{
	public function up()
	{
		\DBUtil::create_table('journals', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'name' => array('constraint' => 25, 'type' => 'varchar'),
			'user' => array('constraint' => 25, 'type' => 'varchar'),
			'datein' => array('type' => 'date'),
			'dateout' => array('type' => 'date'),
			'description' => array('type' => 'text'),
			'photo' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('journals');
	}
}