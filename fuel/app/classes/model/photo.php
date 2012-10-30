<?php

class Model_Photo extends \Model_Crud
{

	protected static $_table_name = 'photos';
        
        public static function add_photo($images) {
            foreach ($images as $image) {
                $q = self::forge()->set(array(
                    'journalid' => \Fuel\Core\Input::post('journal-id'),
                    'file' => $image['file_name'],
                    'date' => date('d-j-Y'),
                    'desc' => ''
                ));
                $q->save();
            }
        }
        
        public static function get_photo($id) {
            $q = self::find_by('journalid',$id,'=',20);
            if($q != null){
                return $q;
            }
        }
        
        public static function photo_detail($id) {
            $q = self::find_by_pk($id);
            if($q != null) {
                return $q;
            }
        }
        
        public static function delete_photo($id) {
            $q = self::find_by_pk($id);
            if($q != null) {
                $q->delete();
            }
        }
}
