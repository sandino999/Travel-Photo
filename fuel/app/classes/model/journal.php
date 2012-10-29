<?php

class Model_Journal extends \Model_Crud
{

	protected static $_table_name = 'journals';
        
        protected static $_rules = array(
            'name' => 'required'
        );
        
        protected static $_properties = array(
            'name',
            'user',
            'datein',
            'dateout',
            'description'
        );
        
        public static function add_journal() {
            $q = Model_Journal::forge()->set(array(
                'name' => \Fuel\Core\Input::post('journal_name'),
                'description' => \Fuel\Core\Input::post('journal_description'),
                'user' => 'Test_user'
            ));
            $q->save();
        }
        
        public static function load_journals() {
            $q = Model_Journal::find_by('user','Test_user','=',10);
            if ($q != NULL) {
                return $q;
            }
        }

}
