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
        $this->template->title = 'Dashboard';
        $this->template->journal_items = Model_Journal::load_journals();
    }
}

?>
