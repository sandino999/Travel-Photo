<?php

class myjournal{

	public static function check_journal($journal_id) {
		
		return Model_Journal::validate_journal($journal_id);	
	}
		
}