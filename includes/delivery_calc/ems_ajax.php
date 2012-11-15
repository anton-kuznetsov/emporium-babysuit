<?php

	// Инициализация

	session_start();
	session_name();

	require_once "../../var.php";
	require_once "../classes.php";

	$ems_city = isset($_REQUEST['ems_city']) ? $_REQUEST['ems_city'] : null;

	//

	$cart_dalc = new Cart_DALC();

	$data = array();

	$data['cart'] = $cart_dalc->GetCartBySession( session_id() );

	$data['cart_items'] = $cart_dalc->GetCartItems( $data['cart']['id'] );

	$weight = 0;

	foreach ( $data['cart_items'] as $item ) {

		$data['products_cost'] += $item['subtotal'];

		$format = $item['format'];

		$weight += $item['weight'] * $item['qty'];

	}

	$data['weight_str'] = number_format( $weight / 1000, 2, '.', '' );

	$data['products_cost_str'] = number_format( $data['products_cost'], 2, '.', ' ' );

	$data['products_cost_str'] = sprintf($format, $data['products_cost_str']);

	// Расчет доставки

	$data['shipping_cost_str'] = '';
	$data['term_str'] = '';

	if ( $ems_city && $data['weight_str'] ) {

		$url  = "http://emspost.ru/api/rest?method=ems.calculate&from=city--cheboksary&to=" . $ems_city . "&weight=" . $data['weight_str'];
		$json = file_get_contents ( $url );
		$data_json = json_decode ( $json, TRUE );

		if (isset($data_json)) {
	
			if ( $data_json['rsp']['stat'] == 'fail' ) {
	
				$data['error'] = $data_json['rsp']['err']['code'] . ' - ' . $data_json['rsp']['err']['msg'];
	
			} else {
	
				$data['shipping_cost'] = number_format( $data_json['rsp']['price'], 2, '.', '' );
				$data['total'] = $data['products_cost'] + $data['shipping_cost'];
				$data['total_str'] = number_format( $data['total'], 2, '.', ' ' );
				$data['total_str'] = sprintf($format, $data['total_str']);

				$data['shipping_cost_str'] = number_format( $data['shipping_cost'], 2, '.', ' ' ) . ' руб.';

				$data['term_str']  = $data_json['rsp']['term']['min'] . '..' . $data_json['rsp']['term']['max'] . ' дн.';
	
			}
		}
	}

	//

	$create_order_ui = new CreateOrder_UI();
	
	echo json_encode(Array(
	    "success"           => ( $data['error'] ) ? "false" : "true",
	    "products_cost_str" => $data['products_cost_str'],
	    "shipping_cost_str" => $data['shipping_cost_str'],
	    "total_str"         => $data['total_str'],
	    "term_str"          => $data['term_str'],
	    "url_checkout"      => $create_order_ui->href(
			array(
				'action'             => 'begin_step1',
				'id_shipping_method' => 2,
				'shipping_params'    => json_encode(Array(
					"city" => $ems_city
				)) 				
			),
			1
		)
	));

?>