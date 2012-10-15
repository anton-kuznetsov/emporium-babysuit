<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'fio',   'type' => 'string' ),
			array( 'name' => 'email', 'type' => 'string' ),
			array( 'name' => 'phone', 'type' => 'string' ),
			array( 'name' => 'dt',    'type' => 'string' ),
		),
		$request
	);

	// Преобразование даты

	$d = explode(".", $item['dt']); 
    
    $dt = new DateTime(); 
    $dt->setDate($d[2], $d[1], $d[0]);
    $dt->setTime(0, 0, 0);
    
    $item['dt'] = $dt->format('Y/m/d H:i:s'); 

	//

	$dalc = new DALC();

	$order = $dalc->SQL_CreateItem(
		'orders',
		array(
			'fio'   => $item['fio'],
			'email' => $item['email'],
			'phone' => $item['phone'],
			'dt'    => $item['dt']
		)
	);

	//

	if ( $order ) {

		echo json_encode(Array(
			"success" => "true",
			"id"      => $order["id"]
		));

	} else {

		echo json_encode(Array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>