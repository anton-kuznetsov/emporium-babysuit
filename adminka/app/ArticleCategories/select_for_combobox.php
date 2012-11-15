<?php

	// Инициализация

	require_once "../classes.php";

	//

	require('./request.php');

	$request = new Request(array('restful' => true));

	//

	$item = Utils::GetRequestParamList (
		array (
			array ( 'name' => 'id_exclude', 'type' => 'int' ),
		),
		$request
	); 

	//

	$where = ' 1 = 1 ';

	// id_exclude - идентификатор исключаемый из списка (текущий каталог)

	if ( isset($item) ) {

		$where .= ' AND id <> ' . $item['id_exclude'] . ' ';

	}

	//

	$article_category_dalc = new ArticleCategory_DALC();

	$article_categories = $article_category_dalc->GetItemsLimit(array("label", "parent", "level"), $where, $start, $limit);

	$article_categories_qty = count( $article_categories ); 

	$array = array();

	// Первый "пустой" элемент списка

	array_push(
		$array,
		array(
			"id" => 0,
			"label" => 'Выберите категорию...',
			"parent" => 0,
			"level" => 1
		)
	);

	//

	if (isset($article_categories)) {

		foreach ($article_categories as $article_category) {

			array_push($array, $article_category);

		}
	}

	echo json_encode(Array(
	    "totalCount" => $article_categories_qty,
	    "items"  => $array
	));

?>