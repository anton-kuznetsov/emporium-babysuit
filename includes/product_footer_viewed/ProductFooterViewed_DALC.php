<?php

class ProductFooterViewed_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// �����������

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/product_footer_viewed/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// ������ �� ��������� ������

		$product_footer_viewed_items = $this->SQL_SelectListDistinct('product_footer_viewed_items', array ( 'id_product' ), " session_id = '" . session_id() . "' ", ' datetime DESC ', 5 );

		$ids_product = '-1';

		foreach ($product_footer_viewed_items as $product_footer_viewed_item) {

			$ids_product .= ',' . $product_footer_viewed_item['id_product'];

		}

		// ������

		$produst_dalc = new Product_DALC();

		$produst_items = $produst_dalc->GetItemsByIds($ids_product);

		// ��������� �� ����� ��������� ����������� ������

		$return_items = array();

		foreach ( $produst_items as $produst_item ) {

			if ( $produst_items[$produst_item['id']]['in_stock'] ) {

				$return_items[$produst_item['id']] = $produst_item;

			}
		}

		// ������

		$currency_dalc = new Currency_DALC();

		$currencies = $currency_dalc->GetItems();

		// ��������� ������ ������������� ����, �����������
		// ������������ ������ ��� ������ ���� �� ��������.
		// ������������� ������������ ������� ����� ������ 3 �����.
		// ������: 
		//     currencies.format = '%s ���.'
		//     products.price = 10000.00
		// ���������:
		//     price_str = '10 000.00 ���.' 

		foreach ($return_items as $return_item) {

			$format = $currencies[$return_item['id_currency']]['format'];
			$price = number_format( $return_items[$return_item['id']]['price'], 2, '.', ' ' );
			$return_items[$return_item['id']]['price_str'] = sprintf($format, $price);

		}

		// ������

		return $return_items;

	}

};

?>