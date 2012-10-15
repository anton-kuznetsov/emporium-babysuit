<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id',     'type' => 'int'    ),
			array( 'name' => 'label',  'type' => 'string' ),
			array( 'name' => 'parent', 'type' => 'int'    ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$dalc->SQL_UpdateItems(
		'categories',
		array( $item ),
		array( 'label', 'parent' )
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>