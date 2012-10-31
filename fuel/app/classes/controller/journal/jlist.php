<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jlist
 *
 * This is the Journal List where the loopings statement
 * for displaying the journals.
 * 
 * @author user
 */
class Controller_journal_jlist extends \Fuel\Core\Controller {
    /*
    public function before() {
        parent::before();
        if(!Fuel\Core\Request::is_hmvc()) {
            \Fuel\Core\Response::redirect();
        }
    }
    */
    public function action_journal_list() {
        $view = \Fuel\Core\View::forge('journal/journal_list');
        $view->journal_items = Model_Journal::load_journals();
        
        return $view;
    }
    
    public function action_journal_photos($id) {
        $view = \Fuel\Core\View::forge('journal/photo_list');
        $view->photo_items = Model_Photo::get_photo($id);
        return $view;
    }
}

?>
