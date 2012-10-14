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

		$data = array();

		$order_dalc = new Order_DALC();

		$order = $order_dalc->GetOrder( $id_order );

		$date = date_create($order['dt']);

		$order['dt_str'] = date_format($date, 'd ') . $month_rus[date_format($date, 'n') - 1] . date_format($date, ' Y');

		//

		$cart_dalc = new Cart_DALC();

		$cart = $cart_dalc->GetCartBySession( session_id() ); 

		$cart_items = $cart_dalc->GetCartItems( $cart['id'] );

		$data = $order;

		$data['cart_items'] = $cart_items;

		$format = '';

		foreach ( $data['cart_items'] as $item ) {

			$data['products_cost'] += $item['subtotal'];

			$format = $item['format'];

		}

		$data['products_cost_str'] = number_format( $data['products_cost'], 2, '.', ' ' );

		$data['products_cost_str'] = sprintf($format, $data['products_cost_str']);

		//

		$data['shipping_cost_str'] = number_format( $data['shipping_cost'], 2, '.', ' ' );

		$data['shipping_cost_str'] = sprintf($format, $data['shipping_cost_str']);

		//

		$data['total'] = $data['products_cost'] + $data['shipping_cost'];

		$data['total_str'] = number_format( $data['total'], 2, '.', ' ' );

		$data['total_str'] = sprintf($format, $data['total_str']);

		// Доставка

		$data['shipping_method'] = $order_dalc->SQL_SelectItem(
			'shipping_methods',
			NULL,
			$data['id_shipping_method']
		);

		$data['country'] = $order_dalc->SQL_SelectItem(
			'countries',
			NULL,
			$data['id_country']
		);

		$data['country_region'] = $order_dalc->SQL_SelectItem(
			'country_regions',
			NULL,
			$data['id_country_region']
		);

		//

		$managers_dalc = new Managers_DALC();

		$data['client_manager'] = $managers_dalc->GetActiveClientManager();

		return $data;

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