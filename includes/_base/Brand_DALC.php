<?php

class Brand_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/_base/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetBrand( $id_brand ) {

		global $site_root;

		$data = $this->SQL_SelectItem('brands', NULL, $id_brand );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetRecomendedProducts( $id_brand, $qty = 4 ) {



		global $site_root;



		$brand_recomended_products_items = $this->SQL_SelectList('brand_recomended_products', NULL, ' id_brand = ' . $id_brand );



		$ids = '-1';



		shuffle($brand_recomended_products_items); // Перемешиваю массив в случайном порядке



		$i = 0;



		foreach ($brand_recomended_products_items as $brand_recomended_products_item) {



			$ids .= ', ' . $brand_recomended_products_item['id_product'];



			if ( ++$i == $qty ) break;



		}



		//



		$product_dalc = new Product_DALC();



		$products = $product_dalc->GetItemsByIds($ids);



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

		$return_items = array();

		foreach ($products as $product) {

			if ( $product['in_stock'] ) {

				$format = $currencies[$product['id_currency']]['format'];
				$price = number_format( $products[$product['id']]['price'], 2, '.', ' ' );

				$return_items[$product['id']] = $product;
				$return_items[$product['id']]['price_str'] = sprintf($format, $price);

			}
		}

		//

		return $return_items;

	}
};



?>