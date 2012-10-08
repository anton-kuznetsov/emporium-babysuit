<?php

	// Инициализация

	require_once "../classes.php";

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

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