<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'articul',     'type' => 'string' ),
			array( 'name' => 'label',       'type' => 'string' ),
			array( 'name' => 'id_brand',    'type' => 'int'    ),
			array( 'name' => 'id_category', 'type' => 'int'    ),
			array( 'name' => 'price',       'type' => 'float'  ),
			array( 'name' => 'overview',    'type' => 'string' ),
			array( 'name' => 'description', 'type' => 'string' ),
			array( 'name' => 'dt',          'type' => 'string' ),
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

	$product = $dalc->SQL_CreateItem(
		'products',
		array(
			'articul'     => $item['articul'],
			'label'       => $item['label'],
			'id_brand'    => $item['id_brand'],
			'id_category' => $item['id_category'],
			'price'       => $item['price'],
			'overview'    => $item['overview'],
			'description' => $item['description'],
			'dt'          => $item['dt']
		)
	);

	//

	if ( $product ) {

		echo json_encode(Array(
			"success" => "true",
			"id"      => $product["id"]
		));

	} else {

		echo json_encode(Array(
			"success" => "false",
			"msg"     => ""
		));

	}

?>