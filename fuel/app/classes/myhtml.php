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
        public static function print_r ($array) {
            print '<pre>';
            print_r($array);
            print '</pre>';
        }
    }
