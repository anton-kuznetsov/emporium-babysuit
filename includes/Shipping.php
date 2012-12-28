<?php

class Shipping {

	//--------------------------------------------------------------------------
	//

	function __construct() {

	}

	//--------------------------------------------------------------------------
	//

	public function Calc( $id_shipping_method, $shipping_params, $order_items ) {

		$res = 0.0;

		switch ($id_shipping_method) {
			case 1 :
				$res = Shipping::Calc_RussianPostFirstClass($order_items);
				break;
			case 2 :
				$res = Shipping::Calc_EMS($order_items, $shipping_params);
				break;
		}

		return $res;

	}

	//--------------------------------------------------------------------------
	// Бандероль заказная массой до 100 г - 114,46
	// Бандероль с объявленной ценностью массой до 100 г - 154,58 
	// Дополнительно взимается плата за каждые последующие полные/неполные 100 г - 17,11

	public function Calc_RussianPostFirstClass( $order_items ) {

		$res = 0.0;

		foreach ($order_items as $item) {

			$item['weight'] = 2050 * $item['qty'];

			$res += 114.46 + (ceil($item['weight'] / 100) - 1) * 17.11;

		}

		$res = number_format( $res, 2, '.', '' ) + 0.0;

		return $res;

	}

	//--------------------------------------------------------------------------
	//

	public function Calc_EMS( $order_items, $shipping_params_json ) {

		$weight = 0.0;

		foreach ($order_items as $item) {

			$weight += 2050.0 * $item['qty'];

		}

		$weight_str = number_format( $weight/1000, 2, '.', ' ' );

		// Параметры

		$shipping_params = json_decode($shipping_params_json, 1);

		// Расчет доставки
		
		$shipping_cost = 0.0;
	
		if ( $shipping_params['city'] && $weight_str ) {
	
			$url  = "http://emspost.ru/api/rest?method=ems.calculate&from=city--cheboksary&to=" . $shipping_params['city'] . "&weight=" . $weight_str;
			$json = file_get_contents ( $url );
			$data_json = json_decode ( $json, TRUE );
	
			if (isset($data_json)) {
		
				if ( $data_json['rsp']['stat'] == 'fail' ) {
		
					$data['error'] = $data_json['rsp']['err']['code'] . ' - ' . $data_json['rsp']['err']['msg'];
		
				} else {

					$shipping_cost = $data_json['rsp']['price'];

				}
			}
		}
	
		//

		$res = number_format( $shipping_cost, 2, '.', '' ) + 0.0;

		return $res;

	}

}

?>