<?php

namespace Fuel\Migrations;

class Create_photos
{
	public function up()
	{
		\DBUtil::create_table('photos', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'journalid' => array('constraint' => 11, 'type' => 'int'),
			'file' => array('constraint' => 255, 'type' => 'varchar'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('photos');
	}
}