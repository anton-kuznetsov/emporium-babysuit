﻿<?php

	// Инициализация

	require_once "../classes.php";

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	require('./request.php');

	$request = new Request(array('restful' => true));

	//

	$id_product = 0;

	if (isset($_REQUEST['id_product'])) {

		$id_product = $_REQUEST['id_product'];

	} else {

		if (isset($request->params->id_product)) {

			$id_product = $request->params->id_product;

		}
	}

	// Получить массив имён изображения
 
	$product_dalc = new Product_DALC();
	
	$product_photos = $product_dalc->GetPhotos( $id_product );

	//

	$images = array();

	$site_path = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/";

	$dir = $site_path . "upload/original/";
	$dir_thumbs = $site_path . "upload/250x250/";

	$site_url = "http://localhost/babysuit/";

	$url = $site_url . "upload/original/";
	$url_thumbs = $site_url . "upload/250x250/";

	if ( isset($product_photos) ) {

		foreach ( $product_photos as $product_photo ) {

			$name = $product_photo["file_name"];

			if (!preg_match('/\.(jpg|gif|png)$/', $name)) continue;
		
			$size    = filesize($dir . $name);
			$lastmod = filemtime($dir . $name) * 1000;
		
			array_push (
				$images,
				array (
					'id'        => $product_photo["id"],
					'name'      => $name,
					'size'      => $size,
					'lastmod'   => $lastmod,
					'url'       => $url . $name,
					'thumb_url' => $url_thumbs . $name
				)
			);
		
		}
	}

	echo json_encode(Array(
	    "success" => "true",
	    "total"   => count( $images ),
	    "data"    => $images
	));

?>