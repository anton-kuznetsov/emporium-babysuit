<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_product', 'type' => 'int' ),
		),
		$request
	);

	// Получить массив имён изображения
 
	$product_dalc = new Product_DALC();

	$product_photos = $product_dalc->GetPhotos( $item['id_product'] );

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