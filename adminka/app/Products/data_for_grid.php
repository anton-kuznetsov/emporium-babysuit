<?php

	// Инициализация

	require_once "../var.php";
	require_once "../classes.php";
	require_once "../request.php";

	//

	$request = new Request(array('restful' => true));

	$item = Utils::GetRequestParamList (
		array(
			array( 'name' => 'start',    'type' => 'int'                        ),
			array( 'name' => 'limit',    'type' => 'int',    'default' => 25    ),
			array( 'name' => 'sort',     'type' => 'string'                     ),
			array( 'name' => 'dir',      'type' => 'string', 'default' => 'ASC' ),
			array( 'name' => 'filter',   'type' => 'array',  'default' => null  ),
			array( 'name' => 'id_brand', 'type' => 'int'                        ),
		),
		$request
	);

	//

	$where = '';

	if ( isset($item['id_brand']) ) {

		$where = ' id_brand = ' . $item['id_brand'];

	}

	//

	$product_dalc = new Product_DALC();
	
	$product_category_dalc = new Category_DALC();

	$products_qty = $product_dalc->Count($where);

	$products = $product_dalc->GetItemsLimit(array("label", "price", "articul", "id_category"), $where, $start, $limit);

	$array = array();

	if (isset($products)) {

		foreach ($products as $product) {

			$category = $product_category_dalc->GetCategory( $product["id_category"] );
			
			if (
				count($category) &&
				array_key_exists('label', $category)
			) {
	
				$product['category'] = $category['label'];
	
			} else {
	
				$product['category'] = '';
	
			}

			array_push($array, $product);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $products_qty,
	    "items"      => $array
	));

?>