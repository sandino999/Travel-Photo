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
namespace sample;
    use Fuel\Core as kore;

    class MyHtml extends kore\Html {
        private $table = null;

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
        
        public function submit ($fieldname,$print = true,$value = '') {
            $attr = array(
                'id' => $fieldname,
                'class' => 'btn btn-primary'
            );
            $form = '<article class="'. $this->table .'">'.
                    '<section>'.
                    '</section>'.
                    '<section>'.
                    \Fuel\Core\Form::submit($fieldname, 'Submit',$attr).
                    '</section>'.
                    '</article>';
            if ($print == FALSE) {
                return $form;
            } else {
                print $form;
            }
        }
    }
