<?php

class FeaturedProducts_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/featured_products/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$featured_products_items = $this->SQL_SelectAll('featured_products', array ( 'id_product' ));

		$ids_product = '-1';

		foreach ($featured_products_items as $featured_products_item) {

			$ids_product .= ',' . $featured_products_item['id_product'];		

		}

		// Товары

		$produst_dalc = new Product_DALC();

		$product_items = $produst_dalc->GetItemsByIds($ids_product);

		// Результат не будет содержать запрещенные товары

		$return_items = array();

		foreach ($featured_products_items as $featured_products_item) {

			if ( $product_items[$featured_products_item['id_product']]['in_stock'] ) {

				$return_items[$featured_products_item['id']] = $featured_products_item;
				$return_items[$featured_products_item['id']]['product'] = $product_items[$featured_products_item['id_product']];

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

			$format = $currencies[$return_items['product']['id_currency']]['format'];
			$price = number_format( $return_items[$return_item['id']]['product']['price'], 2, '.', ' ' );
			$return_items[$return_item['id']]['product']['price_str'] = sprintf($format, $price);

		}
		
		// Готово

		return $return_items;

	}

};

?>