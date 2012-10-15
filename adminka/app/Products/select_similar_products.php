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

	$where = '';

	if ( isset($item['id_product']) ) {

		$where = ' id_product = ' . $item['id_product'];

	}

	//

	$product_dalc = new Product_DALC();

	$similar_products = $product_dalc->GetAccessories($item['id_product'], 0, 0);

	$similar_products_qty = count($similar_products);

	//

	$array = array();

	if (isset($similar_products)) {

		foreach ($similar_products as $similar_product) {

			array_push($array, $similar_product);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $similar_products_qty,
	    "items"      => $array
	));

?>