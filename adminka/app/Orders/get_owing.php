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

	$order_dalc = new Order_DALC();

	$order = $order_dalc->GetOrder($item['id_order']);

	// Расчет долга

	$order['total'] = 0;

	$order['items'] = $order_dalc->GetOrderItems( $order['id'] );

	if (isset($order['items'])) {

		foreach ($order['items'] as $item) {

			$order['total'] += $item['subtotal'];

		}
	}

	$data = array();
	$data['score'] = $order['total'] + $order['shipping_cost'] - $order['amount_received']; 

	echo json_encode(array(
	    "success" => "true",
	    "total"   => isset( $data ) ? 1 : 0,
	    "data"    => $data
	));

?>