<?php

	// Инициализация

	require_once "../classes.php";

	//

	require('./request.php');

	$request = new Request(array('restful' => true));

	//

	$item = Utils::GetRequestParamList (
		array (
			array ( 'name' => 'id',         'type' => 'int'    ),
			array ( 'name' => 'page_title', 'type' => 'string' ),
			array ( 'name' => 'meta_desc',  'type' => 'string' ),
			array ( 'name' => 'meta_key',   'type' => 'string' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$dalc->SQL_UpdateItems(
		'article_categories',
		array( $item ),
		array( 'page_title', 'meta_desc', 'meta_key' )
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>