<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'start',    'type' => 'int'                        ),
			array( 'name' => 'limit',    'type' => 'int',    'default' => 25    ),
			array( 'name' => 'sort',     'type' => 'string'                     ),
			array( 'name' => 'dir',      'type' => 'string', 'default' => 'ASC' ),
			array( 'name' => 'filter',   'type' => 'array',  'default' => null  ),
		),
		$request
	);

	//

	$where = '';

	$send_message_dalc = new SendMessage_DALC();

	$send_messages = $send_message_dalc->GetItemsLimit(
		array(
			"fio",
			"subject",
			"status",
			"dt"
		),
		$where,
		$start, $limit
	);

	$array = array();

	$send_messages_qty = 0;

	if (isset($send_messages)) {

		$send_messages_qty = count( $send_messages );

		foreach ($send_messages as $send_message) {
	
			array_push($array, $send_message);
	
		}
	}

	echo json_encode(Array(

	    "totalCount" => $send_messages_qty,
	    "items"      => $array

	));

?>