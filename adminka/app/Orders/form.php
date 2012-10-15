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

	$order_dalc = new Order_DALC();

	$order = $order_dalc->GetOrder($item['id']);

	echo json_encode(Array(
	    "success" => "true",
	    "total"   => isset( $order ) ? 1 : 0,
	    "data"    => $order
	));

?>