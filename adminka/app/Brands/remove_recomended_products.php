<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id',  'type' => 'int' ),
			array( 'name' => 'ids', 'type' => 'string', 'default' => '-1' ),
		),
		$request
	);

	//

	$dalc = new Product_DALC();

	$dalc->SQL_DeleteItems(
		'brand_recomended_products',
		' id_brand = ' . $item['id'] . ' AND id_product IN (' . $item['ids'] . ') '
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>