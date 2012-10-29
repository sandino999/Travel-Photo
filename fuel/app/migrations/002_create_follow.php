<?php

namespace Fuel\Migrations;

class Create_follow
{
	public function up()
	{
		\DBUtil::create_table('follow', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'username' => array('constraint' => 25, 'type' => 'varchar'),
			'follow' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('follow');
	}
}