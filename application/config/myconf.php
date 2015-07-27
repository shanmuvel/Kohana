<?php

defined('SYSPATH') or die('No direct script access.');
return array(
    'user_registration_code_length' => 6,
    'code_verification_url' => 'http://localhost:9000/#/agents/code-verification',
    'profile_activation_url' => 'http://localhost:9000/#/agents/profile-activation',
    
    'cfma_formula' => array(
        'G27' => '-PMT(J24,E24*D24,B24)',
        'G26' => 'G11+G21',
        
        
    ),
);
?>