<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Helper Class for User Module. It handles the some common helper functions
 * @author  Shanmuganathan
 */

class Controller_Helper_User extends Controller {
    
    /**
     * To generate 6 digt alpha numeric uniq characters
     * @param type $length
     * @return string
     */
    public static function generate_alpha_numeric_code($length) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $char_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $char_length - 1)];
        }
        return $random_string;
    }

}
