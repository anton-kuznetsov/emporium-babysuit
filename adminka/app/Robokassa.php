<?php

	// Инициализация

	require_once "var.php";
	require_once "classes.php";
	require_once "request.php";

//------------------------------------------------------------------------------

class Robokassa {

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct( ) {

	}

	//--------------------------------------------------------------------------
	// 

	public static function GetPaymentURL ( $id_order = 0, $sum = 0.0 ) {

		global $robocassa_login;
		global $robocassa_pass1;

		//

		$inv_id = $id_order;

		$inv_desc  = "desc";
		$out_summ  = $sum;

		$crc = md5("$robocassa_login:$out_summ:$inv_id:$robocassa_pass1");

		$url_robocassa = 'http://test.robokassa.ru/Index.aspx' . //https://merchant.roboxchange.com/Index.aspx' .
			'?MrchLogin=' . $robocassa_login .
			'&OutSum=' . $out_summ .
			'&InvId=' . $inv_id .
			'&Desc=' . $inv_desc .
			'&SignatureValue=' . $crc;

		return $url_robocassa;

	}

};

//------------------------------------------------------------------------------

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_order', 'type' => 'int' ),
			array( 'name' => 'score', 'type' => 'float' ),
		),
		$request
	);

	/*

	$order_dalc = new Order_DALC();

	$order = $order_dalc->GetOrder($item['id_order']);

	// Расчет долга

	$order['total'] = 0;

	$order['items'] = $order_dalc->GetOrderItems( $order['id'] );

	if (isset($order['items'])) {

		foreach ($order['items'] as $item) {

			$order['total'] += $item['subtotal'];

		}
	}

	$order['score'] = $order['total'] + $order['shipping_cost'] - $order['amount_received']; 

	//

	if ( $order['score'] < 0 ) {

		$order['score'] = 0;

	}

	*/

	$url = Robokassa::GetPaymentURL( $item['id_order'], $item['score'] );

	echo json_encode(array(
	    "success" => "true",
	    "url"     => $url
	));

?>