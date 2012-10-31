<?php

namespace Fuel\Migrations;

class Add_desc_to_photos
{
	public function up()
	{
		\DBUtil::add_fields('photos', array(
			'desc' => array('type' => 'text'),

		));	
	}

	public function down()
	{
		\DBUtil::drop_fields('photos', array(
			'desc'
    
		));
	}
}