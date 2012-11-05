<?php

    class login{
            private $table = null;

            public function __construct($table) {
                $this->table = $table;
            }
            
            public function open_form($attributes,$print=true) {
                $form = Fuel\Core\Form::open($attributes);
                if ($print == TRUE) {
                    print $form;
                } else {
                    return $form;
                }
            }
            
            public function close_form($print=true) {
                $form = Fuel\Core\Form::close();
                if ($print == TRUE) {
                    print $form;
                } else {
                    return $form;
                }
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

            public function submit ($fieldname,$args=null,$print = true,$value = 'Submit') {
                $attr = array(
                    'id' => $fieldname,
                    'class' => 'btn btn-primary'
                );
                $form = '<article class="'. $this->table .'">'.
                        '<section>'.
                        $args.
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