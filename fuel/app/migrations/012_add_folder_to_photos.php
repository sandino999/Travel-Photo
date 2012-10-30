<?php

namespace Fuel\Migrations;

class Add_folder_to_photos
{
	public function up()
	{
		\DBUtil::add_fields('photos', array(
			'desc' => array('constraint' => 10, 'type' => 'varchar'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('photos', array(
			'desc'
    
		));
	}
}