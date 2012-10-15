<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_order', 'type' => 'int' ),
		),
		$request
	);

	//

	$where = '';

	if ( $item['id_order'] ) {

		$where = ' id_order = ' . $item['id_order'];

	}

	//

	$order_dalc = new Order_DALC();

	$order_items = $order_dalc->GetOrderItems( $item['id_order'] );

	$order_items_qty = count ( $order_items );

	$array = array();

	if (isset($order_items)) {

		foreach ($order_items as $order_item) {

			array_push($array, $order_item);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $order_items_qty,
	    "items"  => $array
	));

?>