<?php

namespace Fuel\Migrations;

class Create_likes
{
	public function up()
	{
		\DBUtil::create_table('likes', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'type' => array('constraint' => 25, 'type' => 'varchar'),
			'value' => array('constraint' => 11, 'type' => 'int'),
			'user' => array('constraint' => 25, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('likes');
	}
}