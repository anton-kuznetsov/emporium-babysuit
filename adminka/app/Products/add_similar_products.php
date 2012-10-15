<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id',  'type' => 'int'                       ),
			array( 'name' => 'ids', 'type' => 'string', 'default' => '-1' ),
		),
		$request
	);

	//

	$product_dalc = new Product_DALC();

	$products = $product_dalc->GetItemsByIds($item['ids']);

	if (isset($products)) {

		foreach ($products as $product) {

			$product_dalc->SQL_CreateItem(
				'product_relations',
				array(
					'id_product'   => $item['id'],
					'id_accessory' => $product['id']
				)
			);

		}
	}

	echo json_encode(Array(
		"success" => "true"
	));

?>