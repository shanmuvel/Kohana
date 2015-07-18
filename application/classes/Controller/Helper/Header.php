<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Helper_Header extends Controller {
    
    public static function api_headers($set) {
        $headers = $set->headers('Access-Control-Allow-Origin', '*');
        $headers .= $set->headers('Access-Control-Allow-Credentials', 'true');
        $headers .= $set->headers('Access-Control-Allow-Methods', 'PUT, GET, POST, DELETE, OPTIONS');
        $headers .= $set->headers('Access-Control-Allow-Headers:', 'X-Requested-With');
        $headers .= $set->headers('Access-Control-Allow-Headers',  'accept, Authorization, origin, content-type');
        
        return $headers;
    }
    
}