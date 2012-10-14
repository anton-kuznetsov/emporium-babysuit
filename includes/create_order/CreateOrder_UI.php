<?php

class CreateOrder_UI extends UI {

	protected $folder_class = '';
	protected $data = array();

	protected $href_cart_params = NULL;

	function __construct( $data = array() ) {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/create_order/';

		$this->data = $data;

		$href_order_params = array (
			array ( 'name' => 't',                  'value' => $_REQUEST ['t']                  ),
			array ( 'name' => 'action',             'value' => $_REQUEST ['action']             ),
			array ( 'name' => 'id_order',           'value' => $_REQUEST ['id_order']           ),
			array ( 'name' => 'id_cart',            'value' => $_REQUEST ['id_cart']            ),
			array ( 'name' => 'id_shipping_method', 'value' => $_REQUEST ['id_shipping_method'] ),
			array ( 'name' => 'fio',                'value' => $_REQUEST ['fio']                ),
			array ( 'name' => 'email',              'value' => $_REQUEST ['email']              ),
			array ( 'name' => 'phone',              'value' => $_REQUEST ['phone']              ),
			array ( 'name' => 'id_country',         'value' => $_REQUEST ['id_country']         ),
			array ( 'name' => 'id_country_region',  'value' => $_REQUEST ['id_country_region']  ),
			array ( 'name' => 'shipping_address',   'value' => $_REQUEST ['shipping_address']   ),
		);

	}
	
	//--------------------------------------------------------------------------
	//

	public function render() {

		global $site_root;

		$create_order_bllc = new CreateOrder_BLLC();
		
		$data = $create_order_bllc->GetData( $this->data['id_order'] );

		switch ( $this->data['action'] ) {

			case 'step1':
			case 'back_to_step1':

				$data['countries']       = $create_order_bllc->GetCountries();
				$data['country_regions'] = $create_order_bllc->GetCountryRegions( $data['id_country'] );

				include $this->folder_class . 'tmp/step1.tmp';
				break;

			case 'step2':
				include $this->folder_class . 'tmp/step2.tmp';
				break;
			case 'step3':
				include $this->folder_class . 'tmp/step3.tmp';
				break;
			default:
				include $this->folder_class . 'tmp/empty.tmp';
				break;
		}
	}

	//--------------------------------------------------------------------------
	//

	public function href( $vars = array(), $is_return = 0 ) {

		$href_order_params = array (
			array ( 'name' => 't',        'value' => 'create_order' ),
			array ( 'name' => 'action',   'value' => 'step1'        ),
			array ( 'name' => 'id_order', 'value' => 0              ),
			array ( 'name' => 'id_cart',  'value' => 0              ),
			array ( 'name' => 'id_shipping_method', 'value' => 1    ),
 			array ( 'name' => 'fio',      'value' => ''             ),
 			array ( 'name' => 'email',    'value' => ''             ),
 			array ( 'name' => 'phone',    'value' => ''             ),
 			array ( 'name' => 'id_country',         'value' => 0    ),
			array ( 'name' => 'id_country_region',  'value' => 0    ),
			array ( 'name' => 'shipping_address',   'value' => ''   ),
			array ( 'name' => 'shipping_params',   'value' => ''    )
		);

		$this->href_params = $href_order_params;

		return parent::href( $vars, $is_return );

	}
};

?>