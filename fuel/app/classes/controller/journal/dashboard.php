<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author user
 */
class Controller_journal_dashboard extends \Fuel\Core\Controller_Template {
    public $template = 'journal/dashboard';
    
    public function action_index() {
       $this->template->items = Fuel\Core\Request::forge('journal/jlist/journal_list/')
                ->execute()->response()->body();
    }
    
    public function action_my_journal() {
         $this->template->items = Fuel\Core\Request::forge('journal/jlist/journal_mine/')
                ->execute()->response()->body();
    }

    public function action_photo() {
        $id = $this->param('id');
        $this->template->items = Fuel\Core\Request::forge("journal/jlist/journal_photos/".$id)
                ->execute()->response()->body();
        $this->template->journal = Model_Journal::journal_detail($id);
        $this->template->is_photo = true;
    }
}

?>
