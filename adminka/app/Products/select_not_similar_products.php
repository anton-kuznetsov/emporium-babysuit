<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_product', 'type' => 'int' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$items = $dalc->SQL_SelectList(
		'product_relations',
		NULL,
		' id_product = ' . $item['id_product']
	);

	$ids = $item['id_product'];
	$i   = 0;

	if (isset($items)) {

		foreach ($items as $item) {
	
			$ids .= ', ' . $item['id_accessory'];
	
		}
	}

	//

	$where = ' id NOT IN (' . $ids . ') ';

	$product_dalc = new Product_DALC(); 

	$products_qty = $product_dalc->Count($where);

	$products = $product_dalc->GetItemsLimit(
		array(
			"label",
			"price",
			"articul"
		),
		$where,
		$start, $limit
	);

	//

	$array = array();

	if (isset($products)) {

		foreach ($products as $product) {

			array_push($array, $product);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $products_qty,
	    "items"      => $array
	));

?>