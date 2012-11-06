<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  Description of home
 *  Base Controller for Home
 * 
 *  @author Aldrich Barcenas
 */
class Controller_front_main extends Fuel\Core\Controller_Template {
    public $template = 'front/front template';
    
    public function action_index() {
        $this->template->title = 'Demo Site';
	$this->template->message = '';
    }
	
}
