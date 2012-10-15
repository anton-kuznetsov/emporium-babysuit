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

	$brand_dalc = new Brand_DALC();

	$brand = $brand_dalc->GetBrand($item['id']);

	echo json_encode(Array(
		"success" => "true",
	    "total"   => isset( $brand ) ? 1 : 0,
	    "data"    => $brand
	));

?>