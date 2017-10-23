<?php

$config = ( object ) array (
		'debug' => true,
		'twigTemplate' => 'templates',
		'twigCache' => 'cache',
		'definedSalt' => '',
			/* MySQL */
		'mysqlDebug' => true,
		'mysqlHost' => 'localhost',
		'mysqlUser' => '',
		'mysqlPass' => '',
		'mysqlDb' => array (
			'test' => '',
			),
		'mysqlCharset' => 'utf8'
	);

if ($config->debug === true) {
	error_reporting ( E_ALL );
	ini_set ( 'display_errors', 1 );
}