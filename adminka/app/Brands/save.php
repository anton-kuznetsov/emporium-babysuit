<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id',          'type' => 'int'    ),
			array( 'name' => 'label',       'type' => 'string' ),
			array( 'name' => 'company',     'type' => 'string' ),
			array( 'name' => 'country',     'type' => 'string' ),
			array( 'name' => 'site',        'type' => 'string' ),
			array( 'name' => 'description', 'type' => 'string' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$dalc->SQL_UpdateItems(
		'brands',
		array( $item ),
		array( 'label', 'company', 'country', 'site', 'description' )
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>