<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'id_product', 'type' => 'int'    ),
			array( 'name' => 'ids',        'type' => 'string' ),
			array( 'name' => 'images',     'type' => 'string' ),
		),
		$request
	);

	//

	$dalc = new DALC();

	$dalc->SQL_DeleteItems (
		'product_photos',
		' id IN (' . $item['ids'] . ') '
	);

	//

	$ori_dir       = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/original/";
	$thumb_50_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/50x50/";
	$thumb_78_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/78x78/";
	$thumb_90_dir  = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/90x90/";
	$thumb_250_dir = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/250x250/";
	$thumb_500_dir = $_SERVER["DOCUMENT_ROOT"] . "/babysuit/" . "upload/full/";

	$arrayImg = explode(";", $item['images']);

	foreach($arrayImg as $imgname) {

	    if ($imgname != "") {

	        unlink($dir.$imgname);
	        unlink($thumb_50_dir.$imgname);
	        unlink($thumb_78_dir.$imgname);
	        unlink($thumb_90_dir.$imgname);
	        unlink($thumb_250_dir.$imgname);

	    }
	}

	echo json_encode(Array(
	    "success" => "true"
	));

?>