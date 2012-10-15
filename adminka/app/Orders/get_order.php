<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_order', 'type' => 'int' ),
		),
		$request
	);

	//

	$where = '';

	if ( isset($item['id_order']) ) {

		$where = ' id_order = ' . $item['id_order'];

	}
	
	//

	$order_dalc = new Order_DALC();

	$order = $order_dalc->GetOrder( $item['id_order'] );

// 	echo json_encode(Array(
// 
// 	    "success" => "true",
// 	    "data"    => $order
// 
// 	));

	echo '{success:true,data:{"label":"Cool","type":"ComboBox","value_type":"eet"}}';

// 	echo json_encode( $order );

?>