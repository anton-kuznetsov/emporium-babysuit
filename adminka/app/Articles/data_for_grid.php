<?php

	// Инициализация

	require_once "../classes.php";

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	//

	$where = '';

	$article_dalc = new Article_DALC();
	$article_category_dalc = new ArticleCategory_DALC();

	$articles_qty = $article_dalc->Count();

	$articles = $article_dalc->GetItemsLimit(array("title", "id_article_category", "link_label"), $where, $start, $limit);

	$array = array();

	foreach ($articles as $article) {

		$article_category = $article_category_dalc->GetArticleCategory( $article["id_article_category"] );

		if (
			count($article_category) &&
			array_key_exists("label", $article_category)
		) {

			$article["article_category"] = $article_category["label"];

		} else {

			$article["article_category"] = '';

		}

		array_push($array, $article);

	}

	echo json_encode(Array(

	    "totalCount" => $articles_qty,
	    "items"      => $array

	));

?>