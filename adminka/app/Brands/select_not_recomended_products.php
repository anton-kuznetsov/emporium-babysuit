<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_brand', 'type' => 'int' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$items = $dalc->SQL_SelectList('brand_recomended_products', NULL, ' id_brand = ' . $item['id_brand'] );

	$ids = '-1';
	$i   = 0;

	if (isset($items)) {

		foreach ($items as $item) {
	
			$ids .= ', ' . $item['id_product'];
	
		}
	}

	//

	$where = ' id NOT IN (' . $ids . ') AND id_brand = ' . $item['id_brand'] . ' ';

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
	    "items"  => $array
	));

?>