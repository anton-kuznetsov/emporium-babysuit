<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id',          'type' => 'int'    ),
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

	$dalc->SQL_UpdateItems(
		'products',
		array( $item ),
		array(
			'articul',
			'label',
			'id_brand',
			'id_category',
			'price',
			'overview',
			'description',
			'dt'
		)
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>