<?php



class Product_DALC extends DALC {



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



	public function GetProduct( $id_product ) {



		global $site_root;



		$data = $this->SQL_SelectItem('products', NULL, $id_product );



		$data['href_image_250'] = $site_root . '/upload/250x250/' . $data['href_image_250'];

		$data['href_image_90']  = $site_root . '/upload/90x90/' . $data['href_image_90'];

		$data['href_image_50']  = $site_root . '/upload/50x50/' . $data['href_image_50'];



		return $data;



	}



	//--------------------------------------------------------------------------

	// 



	public function GetItems() {



		global $site_root;



		$items = $this->SQL_SelectAll('products', NULL);



		//



		foreach ($items as $item) {



			$id = $item['id'];



			$items[$id]['href_image_250'] = $site_root . '/upload/250x250/' . $items[$id]['href_image_250'];

			$items[$id]['href_image_90']  = $site_root . '/upload/90x90/' . $items[$id]['href_image_90'];

			$items[$id]['href_image_50']  = $site_root . '/upload/50x50/' . $items[$id]['href_image_50'];



		}



		//



		return $items;



	}

	//--------------------------------------------------------------------------
	//

	public function GetItemsLimit($fields = NULL, $where = '', $start = 0, $limit = 0) {

		global $site_root;

		$items = $this->SQL_SelectList('products', $fields, $where, '', $limit, $start);

		//

		if (isset($items)) {

			foreach ($items as $item) {

				$id = $item['id'];

				if (array_key_exists ('href_image_250', $items[$id])) {

					$items[$id]['href_image_250'] = $site_root . '/upload/250x250/' . $items[$id]['href_image_250'];

				}

				if (array_key_exists ('href_image_90', $items[$id])) {

					$items[$id]['href_image_90']  = $site_root . '/upload/90x90/' . $items[$id]['href_image_90'];

				}

				if (array_key_exists ('href_image_50', $items[$id])) {

					$items[$id]['href_image_50']  = $site_root . '/upload/50x50/' . $items[$id]['href_image_50'];

				}
			}
		}

		//

		return $items;

	}

	//--------------------------------------------------------------------------
	//

	public function Count($where = '') {



		$count = $this->SQL_SelectCount('products', $where);



		return $count;



	}



	//--------------------------------------------------------------------------

	// 



	public function GetPhotos( $id_product ) {

		global $site_root;

		$items = $this->SQL_SelectList('product_photos', NULL, ' id_product = ' . $id_product );

		//

		if ( isset($items) ) {

			foreach ($items as $item) {
	
	
	
				$id = $item['id'];
	
	
	
				$items[$id]['href'] = $site_root . '/upload/full/' . $items[$id]['file_name'];
	
				$items[$id]['href_image_78'] = $site_root . '/upload/78x78/' . $items[$id]['file_name'];
	
	
	
			}

			return $items;

		} else {

			return array();

		}
	}

	//--------------------------------------------------------------------------
	// 

	public function GetAccessories( $id_product, $qty = 4 ) {

		global $site_root;

		$items = $this->SQL_SelectList('product_relations', NULL, ' id_product = ' . $id_product );

		$ids = '-1';

		if ( isset($items) ) {

			shuffle($items); // Перемешиваю массив в случайном порядке

			$i = 0;
	
			foreach ($items as $item) {
	
				$ids .= ', ' . $item['id_accessory'];
	
				if ( ++$i == $qty ) break;
	
			}
		} else {

			$items = array();

		}

		//

		$products = $this->GetItemsByIds($ids);



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



		foreach ($products as $product) {



			$format = $currencies[$product['id_currency']]['format'];

			$price = number_format( $products[$product['id']]['price'], 2, '.', ' ' );

			$products[$product['id']]['price_str'] = sprintf($format, $price);



		}



		//



		return $products;



	}



	//--------------------------------------------------------------------------

	// 



	public function GetAccessoriesByIds( $ids_product = '-1', $qty = 4 ) {



		global $site_root;



		$items = $this->SQL_SelectListDistinct('product_relations', array ( 'id_accessory' ), " id_product IN (" . $ids_product . ") AND id_accessory NOT IN (" . $ids_product . ") " );



		$ids = '-1';



		shuffle($items); // Перемешиваю массив в случайном порядке



		$i = 0;



		foreach ($items as $item) {



			$ids .= ', ' . $item['id_accessory'];



			if ( ++$i == $qty ) break;



		}



		//



		$products = $this->GetItemsByIds($ids);



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



		foreach ($products as $product) {



			$format = $currencies[$product['id_currency']]['format'];

			$price = number_format( $products[$product['id']]['price'], 2, '.', ' ' );

			$products[$product['id']]['price_str'] = sprintf($format, $price);



		}



		//



		return $products;



	}



	//--------------------------------------------------------------------------
	// 

	public function GetItemsByIds($ids) {

		global $site_root;

		$items = $this->SQL_SelectAllByIds('products', $ids);

		//

		foreach ($items as $item) {

			$id = $item['id'];

			$items[$id]['href_image_250'] = $site_root . '/upload/250x250/' . $items[$id]['href_image_250'];
			$items[$id]['href_image_90']  = $site_root . '/upload/90x90/' . $items[$id]['href_image_90'];
			$items[$id]['href_image_50']  = $site_root . '/upload/50x50/' . $items[$id]['href_image_50'];

		}

		//

		return $items;

	}



};



?>