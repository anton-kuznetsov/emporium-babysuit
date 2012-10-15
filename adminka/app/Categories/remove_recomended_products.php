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

	$dalc = new DALC();

	$dalc->SQL_DeleteItems(
		'category_recomended_products',
		' id_category = ' . $item['id'] . ' AND id_product IN (' . $item['ids'] . ') '
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>