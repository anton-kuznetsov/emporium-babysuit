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

	$id = 0;

	if (isset($_REQUEST['id'])) {

		$id = $_REQUEST['id'];

	} else {

		if (isset($request->params->id)) {

			$id = $request->params->id;

		}
	}

	//

	$article_dalc = new Article_DALC();

	$article = $article_dalc->GetArticle($id);

	$article['text'] = str_replace('\"', '"', $article['text']);

	echo json_encode(Array(
	    "success" => "true",
	    "total"   => isset( $article ) ? 1 : 0,
	    "data"    => $article
	));

?>