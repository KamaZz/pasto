<?php

if ( !isset( $_REQUEST['url'] ) )
	exit();

$url = $_REQUEST['url'];
require 'config/environment/parsehandler.class.php';
require 'config/lib/simple_html_dom.php';

$url = parse_url( $url );

$parser = new parsehandler();

$i = 0;
while (true) {
	$page = $parser->getPage( 'http://hotline.ua' . $url['path'] . '?p=' . $i++ );

	$html = str_get_html( $page );

	$productList = $html->find( 'ul.catalog li' );

	if ( !empty( $productList ) ) {
		foreach ($productList as $key => $value) {
			$products[] = array( 'name' => trim( $value->find( 'div.title-box a', 0 )->plaintext ), 'link' => trim( $value->find( 'div.title-box a', 0 )->href ) );
		}
	} else {
		echo json_encode( $products );
		exit();
	}
}


var_dump( trim( $html->find( 'h1', 0 )->plaintext ) );