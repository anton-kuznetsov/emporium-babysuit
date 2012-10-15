<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'start',  'type' => 'int'                        ),
			array( 'name' => 'limit',  'type' => 'int',    'default' => 25    ),
			array( 'name' => 'sort',   'type' => 'string'                     ),
			array( 'name' => 'dir',    'type' => 'string', 'default' => 'ASC' ),
			array( 'name' => 'filter', 'type' => 'array',  'default' => null  ),
		),
		$request
	);

	//

	$where = '';

	$order_dalc = new Order_DALC();

	$orders_qty = $order_dalc->Count();

	$orders = $order_dalc->GetItemsLimit(
		array(
			"fio",
			"email",
			"phone",
			"dt"
		),
		$where,
		$start, $limit
	);

	$array = array();

	foreach ($orders as $order) {

		$order_items = $order_dalc->GetOrderItems( $order["id"] );

		$order_total = 0;

		if ( count($order_items) ) {

			foreach ($order_items as $order_item) {

				$order_total += $order_item["subtotal"];

			}
		}

		$order["total"] = $order_total;

		array_push($array, $order);

	}

	echo json_encode(Array(

	    "totalCount" => $orders_qty,
	    "items"      => $array

	));

?>