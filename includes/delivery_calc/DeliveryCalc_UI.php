<?php

class DeliveryCalc_UI extends UI {

	protected $folder_class = '';

	protected $data = array();

	protected $href_params = NULL;

	function __construct( $data = array() ) {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/delivery_calc/';

		$this->data = $data;

		$href_order_params = array (
			array ( 'name' => 't',           'value' => $_REQUEST ['t']        ),
			array ( 'name' => 'action',      'value' => $_REQUEST ['action']   ),
			array ( 'name' => 'select_city', 'value' => $_REQUEST ['select_city'] ),
			array ( 'name' => 'weight',      'value' => $_REQUEST ['weight']   )
		);

	}

	//--------------------------------------------------------------------------
	//

	public function render() {

		global $site_root;

		$data = array ();

		// Выбираю города куда возможна доставка
	
		$url  = "http://emspost.ru/api/rest/?method=ems.get.locations&type=cities&plain=true";
		$json = file_get_contents ( $url );
		$data_json = json_decode ( $json, TRUE );
	
		$data["cities"] = array();
	
		if (isset($data_json)) {
	
			if ( $data_json['rsp']['stat'] == 'fail' ) {
	
				// $data_json['rsp']['err']['code'] . ' - ' . $data_json['rsp']['err']['msg'];
	
			} else {
	
				$data["cities"] = $data_json['rsp']['locations'];

			}
		}

		// Максимальный вес
	
		$url  = "http://emspost.ru/api/rest/?method=ems.get.max.weight";
		$json = file_get_contents ( $url );
		$data_json = json_decode ( $json, TRUE );
	
		$data['max_weight'] = '';
	
		if (isset($data_json)) {
	
			if ( $data_json['rsp']['stat'] == 'fail' ) {
	
				// $data_json['rsp']['err']['code'] . ' - ' . $data_json['rsp']['err']['msg'];
				$data['max_weight'] = 0;
	
			} else {
	
				$data['max_weight'] = $data_json['rsp']['max_weight'];
	
			}
		}
		
		//

		$data['select_city'] = $this->data['select_city'];
		$data['weight']      = $this->data['weight'];

		$data['html_price'] = '';
		$data['html_term'] = '';

		if ( $this->data['action'] == 'calc' ) {

			if ( $data['select_city'] && $data['weight'] ) {
		
				$url  = "http://emspost.ru/api/rest?method=ems.calculate&from=city--cheboksary&to=" . $data['select_city'] . "&weight=" . $data['weight'];
				$json = file_get_contents ( $url );
				$data_json = json_decode ( $json, TRUE );
		
				if (isset($data_json)) {
			
					if ( $data_json['rsp']['stat'] == 'fail' ) {
			
						$data['html_price'] = $data_json['rsp']['err']['code'] . ' - ' . $data_json['rsp']['err']['msg'];
			
					} else {
			
						$data['html_price'] = $data_json['rsp']['price'] . ' руб.';
						$data['html_term']  = $data_json['rsp']['term']['min'] . '..' . $data_json['rsp']['term']['max'] . ' дн.';
			
					}
				}
			}
		}

		include $this->folder_class . 'tmp/default.tmp';

	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		$href_order_params = array (
			array ( 'name' => 't',           'value' => 'delivery_calc' ),
			array ( 'name' => 'action',      'value' => ''              ),
			array ( 'name' => 'select_city', 'value' => ''              ),
			array ( 'name' => 'weight',      'value' => ''              )
		);

		$this->href_params = $href_order_params;

		return parent::href( $vars, $is_return );

	}

};

?>