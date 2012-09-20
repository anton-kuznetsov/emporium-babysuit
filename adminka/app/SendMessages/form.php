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

	$send_message_dalc = new SendMessage_DALC();

	$send_message = $send_message_dalc->GetMessage($id);

	echo json_encode(Array(
		"success" => "true",
	    "total"   => isset( $send_message ) ? 1 : 0,
	    "data"    => $send_message
	));

?>