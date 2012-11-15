<?php

	// Инициализация

	require_once "../classes.php";
	require_once "../request.php";

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	$request = new Request(array('restful' => true));

	//

	$where = '';

	//

	$wgt_karusel_dalc = new Widget_Karusel_DALC();
	$product_category_dalc = new Category_DALC();
	
	$items_qty = $wgt_karusel_dalc->Count($where);

	$items = $wgt_karusel_dalc->GetItemsLimit(null, $where, $start, $limit);

	//

	$return_items = array();

	if (isset($items)) {

		foreach ($items as $item) {

			$category = $product_category_dalc->GetCategory( $item["product"]["id_category"] );
			
			if (
				count($category) &&
				array_key_exists('label', $category)
			) {
	
				$item["product_category"] = $category;
	
			} else {
	
				$item["product_category"] = array(
					'id'    => 0, 
					'label' => ''
				);

			}

			//

			array_push(
				$return_items,
				array(
					'id'          => $item['id'],
					'id_product'  => $item['id_product'],
					'in_stock'    => $item['product']['in_stock'],
					'articul'     => $item['product']['articul'],
					'label'       => $item['product']['label'],
					'category'    => $item['product_category']['label'],
					'id_category' => $item['product_category']['id'],
					'price'       => $item['product']['price'],
				)
			);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $products_qty,
	    "items"      => $return_items
	));

?>