<?php

/*
Добавить поля в таблицы

products
	meta_keywords
	meta_description
categories
	full_label
	meta_keywords
	meta_description
brands
	meta_keywords
	meta_description

Создать таблицу

info_pages
	id
	title
	meta_keywords
	meta_description
*/

class Page_UI {

	protected $modules = null;

	protected $folder_class = '';

	// Данные страницы
	protected $head = array ();

	//
	function __construct( $modules = array() ) {

		global $folder_root;

		$this->modules = $modules;
		
		$this->folder_class = $folder_root . '/includes/_pages/';

		$this->head = array (
			'title'    => '',
			'keywords' => '',
			'desc'     => '',
		);

	}

	public function render() {

		echo '<div></div>';

	}

};

?>