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

	$item['label'] = '';

	if (isset($_REQUEST['label'])) {

		$item['label'] = $_REQUEST['label'];

	} else {

		if (isset($request->params->label)) {

			$item['label'] = $request->params->label;

		}
	}

	$item['label'] = addslashes($item['label']);

	//

	$item['link_label'] = '';

	if (isset($_REQUEST['link_label'])) {

		$item['link_label'] = $_REQUEST['link_label'];

	} else {

		if (isset($request->params->link_label)) {

			$item['link_label'] = $request->params->link_label;

		}
	}

	$item['link_label'] = addslashes($item['link_label']);

	//

	$item['parent'] = 0;

	if (isset($_REQUEST['parent'])) {

		$item['parent'] = $_REQUEST['parent'];

	} else {

		if (isset($request->params->parent)) {

			$item['parent'] = $request->params->parent;

		}
	}

	//

	$dalc = new DALC();

	$article_category = $dalc->SQL_CreateItem(
		'article_categories',
		array(
			'label'      => $item['label'],
			'link_label' => $item['link_label'],
			'parent'     => $item['parent']
		)
	);

	//

	if ( $article_category ) {

		echo json_encode(Array(
			"success" => "true",
			"id"      => $article_category["id"]
		));

	} else {

		echo json_encode(Array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>