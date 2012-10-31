<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of photo
 *
 * @author user
 */
class Controller_journal_photo extends \Fuel\Core\Controller_Template {
    public $template = 'journal/dashboard photo';
    
    public function before() {
        parent::before();
    }


    public function action_index() {
        $id = $this->param('id');
        $this->template->data = Model_Journal::journal_detail($id);
        $this->template->photos = Model_Photo::get_photo($id);
    }
}

