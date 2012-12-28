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

	$brand_dalc = new Brand_DALC();

	$recomended_products = $brand_dalc->GetRecomendedProducts( $item['id_brand'], 0 );

	$recomended_products_qty = count($recomended_products);

	//

	$array = array();

	if (isset($recomended_products)) {

		foreach ($recomended_products as $recomended_product) {

			array_push($array, $recomended_product);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $recomended_products_qty,
	    "items"  => $array
	));

?>