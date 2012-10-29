<?php

namespace Fuel\Migrations;

class Create_comments
{
	public function up()
	{
		\DBUtil::create_table('comments', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'userid' => array('constraint' => 11, 'type' => 'int'),
			'type' => array('constraint' => 25, 'type' => 'varchar'),
			'value' => array('constraint' => 11, 'type' => 'int'),
			'comment' => array('type' => 'text'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('comments');
	}
}