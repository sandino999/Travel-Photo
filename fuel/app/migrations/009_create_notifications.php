<?php

namespace Fuel\Migrations;

class Create_notifications
{
	public function up()
	{
		\DBUtil::create_table('notifications', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'notif' => array('type' => 'text'),
			'type' => array('constraint' => 25, 'type' => 'varchar'),
			'id' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('notifications');
	}
}