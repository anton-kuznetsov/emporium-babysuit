<?php

class CreateOrder_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/create_order/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetData( $id_order ) {

		global $month_rus;

		$order_dalc = new Order_DALC();

		$order = $order_dalc->GetOrder( $id_order );

		$date = date_create($order['dt']);

		$order['dt_str'] = date_format($date, 'd ') . $month_rus[date_format($date, 'n') - 1] . date_format($date, ' Y');

		//

		$cart_dalc = new Cart_DALC();

		$cart = $cart_dalc->GetCartBySession( session_id() ); 

		if ( $cart['id_order'] ) {

			$order['items'] = $cart_dalc->GetCartItems( $cart['id'] );

		} else {

			$order['items'] = $order_dalc->GetOrderItems( $order['id'] );

		}

		//$data = $order;

		$format = '';

		foreach ( $order['items'] as $item ) {

			$order['products_cost'] += $item['subtotal'];

			$format = $item['format'];

		}

		$order['products_cost_str'] = number_format( $order['products_cost'], 2, '.', ' ' );

		$order['products_cost_str'] = sprintf($format, $order['products_cost_str']);

		//

		$order['shipping_cost_str'] = number_format( $order['shipping_cost'], 2, '.', ' ' );

		$order['shipping_cost_str'] = sprintf($format, $order['shipping_cost_str']);

		//

		$order['total'] = $order['products_cost'] + $order['shipping_cost'];

		$order['total_str'] = number_format( $order['total'], 2, '.', ' ' );

		$order['total_str'] = sprintf($format, $order['total_str']);

		// Доставка

		$order['shipping_method'] = $order_dalc->SQL_SelectItem(
			'shipping_methods',
			NULL,
			$order['id_shipping_method']
		);

		$order['country'] = $order_dalc->SQL_SelectItem(
			'countries',
			NULL,
			$order['id_country']
		);

		$order['country_region'] = $order_dalc->SQL_SelectItem(
			'country_regions',
			NULL,
			$order['id_country_region']
		);

		//

		$managers_dalc = new Managers_DALC();

		$order['client_manager'] = $managers_dalc->GetActiveClientManager();

		return $order;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetCountries() {

		$dalc = new DALC();
		$data = $dalc->SQL_SelectList('countries');
		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetCountryRegions( $id_country ) {

		$dalc = new DALC();
		$data = $dalc->SQL_SelectList(
			'country_regions',
			NULL,
			' id_country = ' . $id_country . ' '
		);

		return $data;

	}
};

?>