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
   
}

?>
