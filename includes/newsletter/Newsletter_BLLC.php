<?php

class Newsletter_BLLC {

	protected $folder_class = '';

	//--------------------------------------------------------------------------
	//

	function __construct() {

		global $folder_root;

		$this->folder_class = $folder_root . '/includes/newsletter/';

	}

};

?>