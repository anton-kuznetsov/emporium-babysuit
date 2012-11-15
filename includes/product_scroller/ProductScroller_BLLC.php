<?php

class ProductScroller_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	// Конструктор

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/product_scroller/';

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		// Запрос на получение данных

		$product_scroller_dalc = new ProductScroller_DALC();

		$items = $product_scroller_dalc->GetItems();

		return $items;

	}

};

?>