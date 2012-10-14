<?php

	// Инициализация

	require_once "../classes.php";

	//

	$item = array();

	require('./request.php');

	$request = new Request(array('restful' => true));

	//

	$item['fio'] = '';

	if (isset($_REQUEST['fio'])) {

		$item['fio'] = $_REQUEST['fio'];

	} else {

		if (isset($request->params->fio)) {

			$item['fio'] = $request->params->fio;

		}
	}

	$item['fio'] = addslashes($item['fio']);

	//

	$item['email'] = '';

	if (isset($_REQUEST['email'])) {

		$item['email'] = $_REQUEST['email'];

	} else {

		if (isset($request->params->email)) {

			$item['email'] = $request->params->email;

		}
	}

	$item['email'] = addslashes($item['email']);

	//

	$item['phone'] = '';

	if (isset($_REQUEST['phone'])) {

		$item['phone'] = $_REQUEST['phone'];

	} else {

		if (isset($request->params->phone)) {

			$item['phone'] = $request->params->phone;

		}
	}

	$item['phone'] = addslashes($item['phone']);

	//

	$item['dt'] = '';

	if (isset($_REQUEST['dt'])) {

		$item['dt'] = $_REQUEST['dt'];

	} else {

		if (isset($request->params->dt)) {

			$item['dt'] = $request->params->dt;

		}
	}

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