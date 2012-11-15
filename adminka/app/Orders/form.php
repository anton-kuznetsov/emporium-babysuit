<?php

	// Инициализация

	require_once "../classes.php";

	require('./request.php');

	$request = new Request(array('restful' => true));

	//

	$id = 0;

	if (isset($_REQUEST['id'])) {

		$id = $_REQUEST['id'];

	} else {

		if (isset($request->params->id)) {

			$id = $request->params->id;

		}
	}

	//

	$order_dalc = new Order_DALC();

	$order = $order_dalc->GetOrder($id);

	//

	$shipping_method = $order_dalc -> SQL_SelectItem('shipping_methods', NULL, $order['id_shipping_method']);
	$country = $order_dalc -> SQL_SelectItem('countries', NULL, $order['id_country']);
	$country_region = $order_dalc -> SQL_SelectItem('country_regions', NULL, $order['id_country_region']);

	$order['shipping_method'] = $shipping_method['label'];
	$order['country']         = $country['label'];
	$order['country_region']  = $country_region['label'];

	//

	echo json_encode(Array(
	    "success" => "true",
	    "total"   => isset( $order ) ? 1 : 0,
	    "data"    => $order
	));

?>