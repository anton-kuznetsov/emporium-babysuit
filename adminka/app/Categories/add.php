<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'label',  'type' => 'string' ),
			array( 'name' => 'parent', 'type' => 'int'    ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$product_category = $dalc->SQL_CreateItem(
		'categories',
		array(
			'label'  => $item['label'],
			'parent' => $item['parent']
		)
	);

	//

	if ( $product_category ) {

		echo json_encode(Array(
			"success" => "true",
			"id"      => $product_category["id"]
		));

	} else {

		echo json_encode(Array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>