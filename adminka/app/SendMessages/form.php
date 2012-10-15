<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id', 'type' => 'int' ),
		),
		$request
	);

	//

	$send_message_dalc = new SendMessage_DALC();

	$send_message = $send_message_dalc->GetMessage($item['id']);

	echo json_encode(Array(
		"success" => "true",
	    "total"   => isset( $send_message ) ? 1 : 0,
	    "data"    => $send_message
	));

?>