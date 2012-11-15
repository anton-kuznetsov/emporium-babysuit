<?php

	// Инициализация

	require_once "../classes.php";

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	//

	$item = array();

	require('./request.php');

	$request = new Request(array('restful' => true));

	//

	$item['title'] = '';

	if (isset($_REQUEST['title'])) {

		$item['title'] = $_REQUEST['title'];

	} else {

		if (isset($request->params->title)) {

			$item['title'] = $request->params->title;

		}
	}

	//

	$item['link_label'] = '';

	if (isset($_REQUEST['link_label'])) {

		$item['link_label'] = $_REQUEST['link_label'];

	} else {

		if (isset($request->params->link_label)) {

			$item['link_label'] = $request->params->link_label;

		}
	}

	//

	$item['id_article_category'] = 0;

	if (isset($_REQUEST['id_article_category'])) {

		$item['id_article_category'] = $_REQUEST['id_article_category'];

	} else {

		if (isset($request->params->id_article_category)) {

			$item['id_article_category'] = $request->params->id_article_category;

		}
	}

	//

	$item['anons'] = '';

	if (isset($_REQUEST['anons'])) {

		$item['anons'] = $_REQUEST['anons'];

	} else {

		if (isset($request->params->anons)) {

			$item['anons'] = $request->params->anons;

		}
	}

	$item['anons'] = addslashes($item['anons']);

	//

	$item['text'] = '';

	if (isset($_REQUEST['text'])) {

		$item['text'] = $_REQUEST['text'];

	} else {

		if (isset($request->params->text)) {

			$item['text'] = $request->params->text;

		}
	}

	$item['text'] = addslashes($item['text']);

	//

	$dalc = new DALC();

	$article = $dalc->SQL_CreateItem(
		'articles',
		array(
			'title'               => $item['title'],
			'link_label'          => $item['link_label'],
			'id_article_category' => $item['id_article_category'],
			'anons'               => $item['anons'],
			'text'                => $item['text']
		)
	);

	//

	if ( $article ) {

		echo json_encode(Array(
			"success" => "true",
			"id"      => $article["id"]
		));

	} else {

		echo json_encode(Array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>