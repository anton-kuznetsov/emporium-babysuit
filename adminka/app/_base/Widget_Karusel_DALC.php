<?php

class Widget_Karusel_DALC extends DALC {

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

	public function Count($where = '') {

		$count = $this->SQL_SelectCount('wgt_karusel_items');

		return $count;

	}

	//--------------------------------------------------------------------------
	//

	public function GetItemsLimit($fields = NULL, $where = '', $start = 0, $limit = 0) {

		global $site_root;

		$items = array();

		if ( $where != '' ) {

			$where = " WHERE " . $where;

		}

		if ( $limit != 0 ) {

			$limit = " LIMIT " . $start .", " . $limit;

		} else {

			$limit = '';

		}

		$result = mysql_query( 
			" SELECT " .
			"    wgt_karusel_items.id " .
			"    , products.id AS id_product " .
			"    , products.id_currency " .
			"    , products.id_category " .
			"    , products.label " .
			"    , products.price " .
			"    , products.articul " .
			"    , products.in_stock " .
			" FROM " .
			"    wgt_karusel_items ".
			"    INNER JOIN products ON products.id = wgt_karusel_items.id_product " .
			$where .
			$limit, $this->db
		);

		if (! $result) {

			die('Неверный запрос: ' . mysql_error());

		}

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

			$items[$row['id']] = array(
				'id'         => $row['id'],
				'id_product' => $row['id_product'],
				'product'    => array(
					'id'          => $row['id_product'],
					'id_currency' => $row['id_currency'],
					'id_category' => $row['id_category'],
					'articul'     => $row['articul'],
					'label'       => $row['label'],
					'price'       => $row['price'],
					'in_stock'    => $row['in_stock'],
				)
			);

		}

		//

		if (isset($items)) {

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

			foreach ($items as $item) {

				$format = $currencies[$item['product']['id_currency']]['format'];
	
				$price = number_format( $items[$item['id']]['product']['price'], 2, '.', ' ' );
	
				$items[$item['id']]['product']['price_str'] = sprintf($format, $price);

			}
		}

		//

		return $items;

	}

};



?>