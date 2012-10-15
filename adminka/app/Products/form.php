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

	$product_dalc = new Product_DALC();

	$product = $product_dalc->GetProduct( $item['id'] );

	echo json_encode(Array(
	    "success" => "true",
	    "total"   => isset( $product ) ? 1 : 0,
	    "data"    => $product
	));

?>