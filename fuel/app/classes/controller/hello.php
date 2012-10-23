<?php
	/**
	 * 
	 */
	class Controller_Hello extends Controller {
		
		public function action_index() {
			return 'Ni hao~';
		}
                
                public function action_buddy($name = 'buddy') {
                    $this->response->body = View::factory('hello',array(
                       'name' =>    $name 
                    ));
                }
	}
	