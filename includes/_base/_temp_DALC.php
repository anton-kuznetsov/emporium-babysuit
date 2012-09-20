<?php

class _temp_DALC extends DALC {

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

	public function Get_temp( $id__temp ) {

		global $site_root;

		$data = $this->SQL_SelectItem('_temps', NULL, $id__temp );

		return $data;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItems() {

		global $site_root;

		$items = $this->SQL_SelectAll('_temps', NULL);

		//

		foreach ($items as $item) {

			$id = $item['id'];

		}

		//

		return $items;

	}

	//--------------------------------------------------------------------------
	// 

	public function GetItemsByIds($ids) {

		global $site_root;

		$items = $this->SQL_SelectAllByIds('_temps', $ids);

		//

		foreach ($items as $item) {

			$id = $item['id'];

		}

		//

		return $items;

	}
};

?>