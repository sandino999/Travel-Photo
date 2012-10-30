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
       Model_Journal::delete_journal($id);
       Fuel\Core\Response::redirect('db');
   }
   
   public function action_addphoto(){
       $upload = myupload::upload_resize();
       Model_Photo::add_photo($upload);
       Fuel\Core\Response::redirect('photo/'.\Fuel\Core\Input::post('journal-id'));
   }
   
   public function action_deletephoto($id,$jid){
       $file = Model_Photo::photo_detail($id);
       Model_Photo::delete_photo($id);
       myupload::delete_images($file->file, $file->date);
       Fuel\Core\Response::redirect('photo/'.$jid);
   }
}

?>
