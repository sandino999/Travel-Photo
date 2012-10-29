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
        
        public static function delete_journal($id) {
            $q = Model_Journal::find_by_pk($id);
            $q->delete();
        }
        
        public static function edit_journal() {
            $q = Model_Journal::find_by_pk(\Fuel\Core\Input::post('journal_id'));
            
            $q->datein = \Fuel\Core\Input::post('date-from');
            $q->dateout = \Fuel\Core\Input::post('date-to');
            $q->name = \Fuel\Core\Input::post('journal-name');
            $q->description = \Fuel\Core\Input::post('description');
            
            $q->save();
        }
        
        public static function add_journal() {
            $q = Model_Journal::forge()->set(array(
                'name' => \Fuel\Core\Input::post('journal_name'),
                'description' => \Fuel\Core\Input::post('journal_description'),
                'user' => 'Test_user'
            ));
            $q->save();
        }
        
        public static function journal_detail() {
            $q = Model_Journal::find_by_pk(\Fuel\Core\Input::post('id'));
            if ($q != NULL) {
                return $q;
            }
        }

        public static function load_journals() {
            $q = Model_Journal::find_by('user','Test_user','=',10);
            if ($q != NULL) {
                return $q;
            }
        }

}
