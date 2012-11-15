<?php

	// Инициализация

	require_once "../classes.php";

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	// Только оформленные платежи

	$where = ' status = 2 ';

	//

	$order_dalc = new Order_DALC();

	$orders_qty = $order_dalc->Count();

	$orders = $order_dalc->GetItemsLimit(
		array(
			"fio",
			"email",
			"phone",
			"dt",
			"shipping_cost",
			"amount_received"
		),
		$where,
		$start, $limit
	);

	$array = array();

	foreach ($orders as $order) {

		$order_items = $order_dalc->GetOrderItems( $order["id"] );

		$products_cost = 0;

		if ( count($order_items) ) {

			foreach ($order_items as $order_item) {

				$products_cost += $order_item["subtotal"];

			}
		}

		$order["products_cost"] = $products_cost;
		$order["total"]         = $products_cost + $order['shipping_cost'];

		array_push($array, $order);

	}

	echo json_encode(Array(

	    "totalCount" => $orders_qty,
	    "items"      => $array

	));

?>