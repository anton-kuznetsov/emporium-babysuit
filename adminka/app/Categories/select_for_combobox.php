<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$where = '';

	$category_dalc = new Category_DALC();

	$categories_qty = $category_dalc->Count($where);

	$categories = $category_dalc->GetItemsLimit(
		array(
			"label",
			"parent",
			"level"
		),
		$where,
		$start, $limit
	);

	$array = array();

	// Первый "пустой" элемент списка

	array_push(
		$array,
		array(
			"id"     => 0,
			"label"  => 'Выберите категорию...',
			"parent" => 0,
			"level"  => 1
		)
	);

	//

	if (isset($categories)) {

		foreach ($categories as $category) {

			array_push($array, $category);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $categories_qty,
	    "items"  => $array
	));

?>