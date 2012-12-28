<?php

class ShopingCart_UI extends UI {

	protected $folder_class = '';

	protected $slider = NULL;

	protected $href_cart_params = NULL;

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/shoping_cart/';

		$href_cart_params = array (
			array ( 'name' => 't',          'value' => $_REQUEST ['t']          ),
			array ( 'name' => 'action',     'value' => $_REQUEST ['action']     ),
			array ( 'name' => 'id_product', 'value' => $_REQUEST ['id_product'] ),
			array ( 'name' => 'id_item',    'value' => $_REQUEST ['id_item']    ),
			array ( 'name' => 'qty',        'value' => $_REQUEST ['qty']        )
		);

	}

	public function render() {

		global $site_root;

		$shoping_cart_bllc = new ShopingCart_BLLC();

		$data = $shoping_cart_bllc->GetItems();

		//

		$data['shipment'] = array(
			'russian_post' => array( 'total' => 0, 'total_str' => '' ),
			'ems'          => array( 'total' => 0, 'total_str' => '' ),
		);

		foreach ($data['cart_items'] as $item) {

			$item['weight'] = 2050 * $item['qty'];

			$data['shipment']['russian_post']['total'] += 114.46 + (ceil($item['weight'] / 100) - 1) * 17.11;
				// Бандероль заказная массой до 100 г - 114,46
				// Бандероль с объявленной ценностью массой до 100 г - 154,58 
				// Дополнительно взимается плата за каждые последующие полные/неполные 100 г - 17,11

		}

		$data['shipment']['russian_post']['total']     = number_format( $data['shipment']['russian_post']['total'], 2, '.', ' ' );
		$data['shipment']['russian_post']['total_str'] = sprintf('%s руб.', $data['shipment']['russian_post']['total']);

		// EMS
		// Выбираю города куда возможна доставка
	
		$url  = "http://emspost.ru/api/rest/?method=ems.get.locations&type=cities&plain=true";
		$json = file_get_contents ( $url );
		$data_json = json_decode ( $json, TRUE );
	
		$data['shipment']['ems']["cities"] = array();
	
		if (isset($data_json)) {
	
			if ( $data_json['rsp']['stat'] == 'fail' ) {
	
				// $data_json['rsp']['err']['code'] . ' - ' . $data_json['rsp']['err']['msg'];
	
			} else {
	
				$data['shipment']['ems']["cities"] = $data_json['rsp']['locations'];

			}
		}

		//

		if ( is_null($data) || ! array_key_exists('cart_items', $data) || is_null($data['cart_items']) ) {

			include $this->folder_class . 'tmp/empty.tmp';

		} else {

			include $this->folder_class . 'tmp/default.tmp';
		
		}
	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		$href_cart_params = array (
			array ( 'name' => 't',          'value' => 'cart' ),
			array ( 'name' => 'action',     'value' => ''     ),
			array ( 'name' => 'id_product', 'value' => 0      ),
			array ( 'name' => 'id_item',    'value' => 0      ),
			array ( 'name' => 'qty',        'value' => 0      )
		);

		$this->href_params = $href_cart_params;

		return parent::href( $vars, $is_return );

	}
};

?>