<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of journal
 *
 * @author Aldrich Allen Barcenas
 */
class Controller_rest_journal extends \Fuel\Core\Controller_Template {
    public $template = 'template/journal edit';
    
    public function action_journal_detail(){
        $this->template->data = Model_Journal::journal_detail();
    }
}
