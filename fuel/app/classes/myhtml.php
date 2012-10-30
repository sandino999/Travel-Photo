<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Easy Customization of forms and other HTML manner
 *
 * @author Aldrich Allen Barcenas
 */
    class MyHtml extends Fuel\Core\Html {
        private $table = null;

        public static function print_r ($array) {
            print '<pre>';
            print_r($array);
            print '</pre>';
        }
        
        public function __construct($table) {
            $this->table = $table;
        }

        public function input($fieldname,$type,$placeholder,$print = true,$value = '',$input='input') {
            $attr = array(
                'id' => $fieldname,
                'type' => $type
            );
            $form = '<article class="'. $this->table .'">'.
                    '<section>'.
                    '<label>'.$placeholder.'</label>'.
                    '</section>'.
                    '<section>'.
                    \Fuel\Core\Form::$input($fieldname, $value,$attr).
                    '</section>'.
                    '</article>';
            if ($print == FALSE) {
                return $form;
            } else {
                print $form;
            }
        }

        public function textarea ($fieldname,$type,$placeholder,$print = true,$value = '') {
            $attr = array(
                'id' => $fieldname,
                'type' => $type,
                'row' => 20
            );
            $form = '<article class="'. $this->table .'">'.
                    '<section>'.
                    '<label>'.$placeholder.'</label>'.
                    '</section>'.
                    '<section>'.
                    \Fuel\Core\Form::textarea($fieldname, $value,$attr).
                    '</section>'.
                    '</article>';
            if ($print == FALSE) {
                return $form;
            } else {
                print $form;
            }
        }
        
        public function submit ($fieldname,$print = true,$value = 'Submit') {
            $attr = array(
                'id' => $fieldname,
                'class' => 'btn btn-primary'
            );
            $form = '<article class="'. $this->table .'">'.
                    '<section>'.
                    '</section>'.
                    '<section>'.
                    \Fuel\Core\Form::submit($fieldname, $value ,$attr).
                    '</section>'.
                    '</article>';
            if ($print == FALSE) {
                return $form;
            } else {
                print $form;
            }
        }
        
        public function hidden ($fieldname,$value='',$print = true){
            $attr = array(
                'id' => $fieldname,
                'class' => 'btn btn-primary'
            );
            $form = '<article class="'. $this->table .'">'.
                    '<section>'.
                    '</section>'.
                    '<section>'.
                    \Fuel\Core\Form::hidden($fieldname, $value).
                    '</section>'.
                    '</article>';
            if ($print == FALSE) {
                return $form;
            } else {
                print $form;
            }
        }
    }
