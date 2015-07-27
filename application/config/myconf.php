<?php

defined('SYSPATH') or die('No direct script access.');
return array(
    'user_registration_code_length' => 6,
    'code_verification_url' => 'http://localhost:9000/#/agents/code-verification',
    'profile_activation_url' => 'http://localhost:9000/#/agents/profile-activation',
    //'code_verification_url' => 'http://af-waterproofing.com/krcfm/#/agents/code-verification',
   // 'profile_activation_url' => 'http://af-waterproofing.com/krcfm/#/agents/profile-activation',
    'client_finance_type' => array(
        "type1" => "mortgage1",
        "type2" => "mortgage2",
        "type3" => "creditcard"
    )
);
?>