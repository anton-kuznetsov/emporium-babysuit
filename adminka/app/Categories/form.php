<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id', 'type' => 'int' ),
		),
		$request
	);

	//

	$category_dalc = new Category_DALC();

	$category = $category_dalc->GetCategory($item['id']);

	echo json_encode(Array(
		"success" => "true",
	    "total"   => isset( $category ) ? 1 : 0,
	    "data"    => $category
	));

?>