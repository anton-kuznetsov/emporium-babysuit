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

	$id_article_category = 0;

	if (isset($_REQUEST['id_article_category'])) {

		$id_article_category = $_REQUEST['id_article_category'];

	} else {

		if (isset($request->params->id_article_category)) {

			$id_article_category = $request->params->id_article_category;

		}
	}

	// Проверяю, что параметр id_brand существует

	if ( $id_article_category ) {

		$where = ' id_article_category = ' . $id_article_category;

	}

	//

	$article_dalc = new Article_DALC();

	$articles = $article_dalc->GetItemsLimit(array("title", "id_article_category", "link_label"), $where, $start, $limit);

	$articles_qty = count($articles);

	$array = array();

	foreach ($articles as $article) {

		array_push($array, $article);

	}

	echo json_encode(Array(

	    "totalCount" => $articles_qty,
	    "items"      => $array

	));

?>