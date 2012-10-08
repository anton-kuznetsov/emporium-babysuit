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

	//

	$item['company'] = '';

	if (isset($_REQUEST['company'])) {

		$item['company'] = $_REQUEST['company'];

	} else {

		if (isset($request->params->company)) {

			$item['company'] = $request->params->company;

		}
	}

	//

	$item['country'] = 0;

	if (isset($_REQUEST['country'])) {

		$item['country'] = $_REQUEST['country'];

	} else {

		if (isset($request->params->country)) {

			$item['country'] = $request->params->country;

		}
	}

	//

	$item['site'] = 0;

	if (isset($_REQUEST['site'])) {

		$item['site'] = $_REQUEST['site'];

	} else {

		if (isset($request->params->site)) {

			$item['site'] = $request->params->site;

		}
	}

	//

	$item['description'] = 0;

	if (isset($_REQUEST['description'])) {

		$item['description'] = $_REQUEST['description'];

	} else {

		if (isset($request->params->description)) {

			$item['description'] = $request->params->description;

		}
	}

	//

	$dalc = new DALC();

	$brand = $dalc->SQL_CreateItem(
		'brands',
		array(
			'label'       => $item['label'],
			'company'     => $item['company'],
			'country'     => $item['country'],
			'site'        => $item['site'],
			'description' => $item['description']
		)
	);

	//

	if ( $brand ) {

		echo json_encode(Array(
			"success" => "true",
			"id"      => $brand["id"]
		));

	} else {

		echo json_encode(Array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>