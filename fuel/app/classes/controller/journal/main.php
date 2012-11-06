<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author user
 */

class Controller_journal_main  extends Controller {
   
   public function action_add () {
       Model_Journal::add_journal();
       Fuel\Core\Response::redirect('db');
   }
   
   public function action_edit () {
       Model_Journal::edit_journal();
       Fuel\Core\Response::redirect('db');
   }
   
   public function action_delete($id) {
       $files = Model_Photo::get_photo($id, false);
       
       if (count($files) > 0) {
           $this->delete_journal_photos($files);
       }
       
       Model_Journal::delete_journal($id);
       Fuel\Core\Response::redirect('db');
   }
   
   public function action_addphoto(){
       $upload = myupload::upload_resize();
       Model_Photo::add_photo($upload);
       Fuel\Core\Response::redirect('photo/'.\Fuel\Core\Input::post('journal-id'));
   }
   
   public function action_deletephoto($id,$jid){
       $this->delete_single_photo($id, $jid);
       Fuel\Core\Response::redirect('photo/'.$jid);
   }
   
   private function delete_single_photo($id,$jid){
       $file = Model_Photo::photo_detail($id);
       Model_Photo::delete_photo($id);
       myupload::delete_images($file->file, $file->date);
   }
   
   private function delete_journal_photos($files) {
       foreach($files as $file) {
           $this->delete_single_photo($file->id, $file->date);
       }
   }
}

?>
