<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$where = '';

	$category_dalc = new Category_DALC();

	$categories_qty = $category_dalc->Count();

	$categories = $category_dalc->GetItemsLimit(
		array(
			"label",
			"level",
			"parent"
		),
		$where,
		$start, $limit
	);

	$array = array();

	foreach ($categories as $category) {

		array_push($array, $category);

	}

	echo json_encode(Array(

	    "totalCount" => $categories_qty,
	    "items"      => $array

	));

?>