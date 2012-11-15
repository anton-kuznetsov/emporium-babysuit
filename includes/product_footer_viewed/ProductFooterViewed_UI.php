<?php

class ProductFooterViewed_UI extends FooterViewed_UI {

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/product_footer_viewed/';

		$this->title = '<span><span class="color">Последние</span> просмотренные товары</span>';

	}

	public function render() {

		$product_footer_viewed_bllc = new ProductFooterViewed_BLLC();

		$data = $product_footer_viewed_bllc->GetItems();

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>