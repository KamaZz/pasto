<?php

define( 'ENVIRONMENT', realpath( dirname( __FILE__ ) ) );
require ENVIRONMENT . '/config.class.php';
require ENVIRONMENT . '/../lib/mysql.class.php';

class parsehandler extends MySQL {

	function __construct () {
		global $config;
		$this->mysqlDebug = $config->mysqlDebug;
		$this->debug = $config->debug;
		$this->imagesPath = $config->imagesPath;
		$this->mysql = new MySQL( false, $config->mysqlHost, $config->mysqlUser, $config->mysqlPass, $config->mysqlDb['hardware'], $config->mysqlCharset );
	}

	function getPage( $url ) {
		if ( ini_get( 'allow_url_fopen' ) ) {
			$page = file_get_contents( $url );
		} else {
			if ( !is_callable( 'curl_init' ) )
				die( "Can not download page!\r\nSet \"allow_url_fopen\" to true, or install php5-curl package" );
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
			$page = curl_exec( $ch );
			curl_close( $ch );
		}
		
		return $page;
	}

	function getImage ( $url ) {
		$imagePath = $this->imagesPath . md5( $url ) . '.' . $this->getExtension( $url );
		if ( ini_get( 'allow_url_fopen' ) ) {
			file_put_contents( $imagePath, file_get_contents( $url ) );
		} else {
			if ( !is_callable( 'curl_init' ) )
				die( "Can not download image!\r\nSet \"allow_url_fopen\" to true, or install php5-curl package" );
			$ch = curl_init( $url );
			$fp = fopen( $imagePath, 'wb' );
			curl_setopt( $ch, CURLOPT_FILE, $fp );
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 5 );
			curl_exec( $ch );
			curl_close( $ch );
			fclose( $fp );
		}
		
		return $imagePath;
	}

	function getExtension ( $filename ) {
		return substr( strrchr( $filename, '.' ), 1 );
	}
}