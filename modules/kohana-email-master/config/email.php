<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	Kohana::DEVELOPMENT => array
        (
//        'default' => array(
//            'driver' => 'smtp',
//            'hostname' => 'smtp.mandrillapp.com',
//            'port' => '587',
//            'username' => 'shanmu.roxy@gmail.com',
//            'password' => 'Hz_v85Jv1GPZ14jp4YBCOg'
//        )
        'default' => array(
            'driver' => 'smtp',
            'hostname' => 'mail.af-waterproofing.com',
            'port' => '25',
            'username' => 'nimalan',
            'password' => 'Canada2015'
        )
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
