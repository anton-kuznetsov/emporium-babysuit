<?php

class PopularFooterList_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/popular_footer_list/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$produst_dalc = new Product_DALC();

		$product_items = $produst_dalc->SQL_SelectList('products', NULL, 'in_stock = 1', 'count_show DESC', '6');

		return $product_items;

	}

};

?>