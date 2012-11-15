<?php

class ProductFooterViewed_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/product_footer_viewed/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$product_footer_viewed_items = $this->SQL_SelectListDistinct('product_footer_viewed_items', array ( 'id_product' ), " session_id = '" . session_id() . "' ", ' datetime DESC ', 5 );

		$ids_product = '-1';

		foreach ($product_footer_viewed_items as $product_footer_viewed_item) {

			$ids_product .= ',' . $product_footer_viewed_item['id_product'];

		}

		// Товары

		$produst_dalc = new Product_DALC();

		$produst_items = $produst_dalc->GetItemsByIds($ids_product);

		// Результат не будет содержать запрещенные товары

		$return_items = array();

		foreach ( $produst_items as $produst_item ) {

			if ( $produst_items[$produst_item['id']]['in_stock'] ) {

				$return_items[$produst_item['id']] = $produst_item;

			}
		}

		// Валюта

		$currency_dalc = new Currency_DALC();

		$currencies = $currency_dalc->GetItems();

		// Используя формат представления цены, выполняется
		// формирование строки для показа цены на странице.
		// Дополнительно выставляются пробелы через каждые 3 цифры.
		// Пример: 
		//     currencies.format = '%s руб.'
		//     products.price = 10000.00
		// Результат:
		//     price_str = '10 000.00 руб.' 

		foreach ($return_items as $return_item) {

			$format = $currencies[$return_item['id_currency']]['format'];
			$price = number_format( $return_items[$return_item['id']]['price'], 2, '.', ' ' );
			$return_items[$return_item['id']]['price_str'] = sprintf($format, $price);

		}

		// Готово

		return $return_items;

	}

};

?>