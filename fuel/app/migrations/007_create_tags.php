<?php

namespace Fuel\Migrations;

class Create_tags
{
	public function up()
	{
		\DBUtil::create_table('tags', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'tag' => array('constraint' => 25, 'type' => 'varchar'),
			'type' => array('constraint' => 25, 'type' => 'varchar'),
			'value' => array('constraint' => 11, 'type' => 'int'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('tags');
	}
}