<?php

class DeliveryCalcPage_UI extends Page_UI {

	protected $options = array();

	function __construct( $modules = array(), $options = array() ) {

		global $folder_root;

		parent::__construct( $modules );

		$this->folder_class = $folder_root . '/includes/_pages/DeliveryCalcPage/';

		$this->options = $options;

	}

	public function render() {

		global $site_root;

		include $this->folder_class . 'tmp/default.tmp';

	}

};

?>