<?php

class Newsletter_DALC extends DALC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	//

	function __construct() {

		global $folder_root;

		parent::__construct();

		$this->folder_class = $folder_root . '/includes/newsletter/';

	}

};

?>