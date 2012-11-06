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
                'user' => Fuel\Core\Session::get('username')
            ));
            $q->save();
        }
        
        public static function journal_detail($id = NULL) {
            if ($id == NULL) {
                $value =  \Fuel\Core\Input::post('id');
            } else {
                $value = $id;
            }
            
            $q = Model_Journal::find_by_pk($value);
            if ($q != NULL) {
                return $q;
            }
        }
        
        public static function load_my_journals() {
            $q = self::find_by_user(Fuel\Core\Session::get('username'));
            
            if($q != null) {
                return $q;
            }
        }

        public static function load_journals() {
            $q = self::find_all(10);
            if ($q != NULL) {
                return $q;
            }
        }

}
