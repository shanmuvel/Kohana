<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	Kohana::DEVELOPMENT => array
        (
        'default' => array(
            'driver' => 'smtp',
            'hostname' => 'smtp.mandrillapp.com',
            'port' => '587',
            'username' => 'shanmu.roxy@gmail.com',
            'password' => 'Hz_v85Jv1GPZ14jp4YBCOg'
        )
//         (
//        'default' => array(
//            'driver' => 'smtp',
//            'hostname' => 'email-smtp.us-east-1.amazonaws.com',
//            'port' => '25',
//            'encryption'=>'tls',
//            'username' => 'AKIAIRK6AVMZCIFCDABQ',
//            'password' => 'AnufuPHF8oBa0JdwyHvjRFdrV5s1mNP68q/fAqFi11/O'
//        )
    ),
	Kohana::PRODUCTION  => array
	(
		'default' => array(
			'driver'     => 'smtp',
			'hostname'   => 'smtp.domain.tld',
			'username'   => 'example@domain.tld',
			'password'   => '123456'
		)
	),
);
