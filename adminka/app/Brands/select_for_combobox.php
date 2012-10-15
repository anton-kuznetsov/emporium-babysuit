<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$where = '';

	$brand_dalc = new Brand_DALC();

	$brands_qty = $brand_dalc->Count($where);

	$brands = $brand_dalc->GetItemsLimit(array("label"), $where, $start, $limit);

	$array = array();

	// Первый "пустой" элемент списка

	array_push(
		$array,
		array(
			"id"    => 0,
			"label" => 'Выберите бренд...'
		)
	);

	//

	if (isset($brands)) {

		foreach ($brands as $brand) {

			array_push($array, $brand);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $brands_qty,
	    "items"      => $array
	));

?>