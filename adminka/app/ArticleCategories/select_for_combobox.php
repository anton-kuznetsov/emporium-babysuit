<?php

	// Инициализация

	require_once "../classes.php";

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	require('./request.php');

	$request = new Request(array('restful' => true));

	//

	$where = '';

	//

	$article_category_dalc = new ArticleCategory_DALC();

	$article_categories = $article_category_dalc->GetItemsLimit(array("label", "parent", "level"), $where, $start, $limit);

	$article_categories_qty = count( $article_categories ); 

	$array = array();

	// Первый "пустой" элемент списка

	array_push(
		$array,
		array(
			"id" => 0,
			"label" => 'Выберите категорию...',
			"parent" => 0,
			"level" => 1
		)
	);

	//

	if (isset($article_categories)) {

		foreach ($article_categories as $article_category) {

			array_push($array, $article_category);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $article_categories_qty,
	    "items"  => $array
	));

?>