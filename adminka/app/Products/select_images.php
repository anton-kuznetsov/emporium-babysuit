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

	if ( isset($product_photos) ) {

		foreach ( $product_photos as $product_photo ) {

			$name = $product_photo["file_name"];

			if (!preg_match('/\.(jpg|gif|png)$/', $name)) continue;
		
			$size    = filesize($ORIGINAL_UPLOAD_FOLDER . $name);
			$lastmod = filemtime($ORIGINAL_UPLOAD_FOLDER . $name) * 1000;
		
			array_push (
				$images,
				array (
					'id'        => $product_photo["id"],
					'name'      => $name,
					'size'      => $size,
					'lastmod'   => $lastmod,
					'url'       => $ORIGINAL_UPLOAD_URL . $name,
					'thumb_url' => $THUMBS_UPLOAD_URL . $name
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