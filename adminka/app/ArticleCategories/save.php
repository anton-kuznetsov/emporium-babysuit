<?php

	// Инициализация

	require_once "../classes.php";

	$start   = isset($_REQUEST['start'])  ? $_REQUEST['start']  : 0;
	$limit   = isset($_REQUEST['limit'])  ? $_REQUEST['limit']  : 25;
	$sort    = isset($_REQUEST['sort'])   ? $_REQUEST['sort']   : '';
	$dir     = isset($_REQUEST['dir'])    ? $_REQUEST['dir']    : 'ASC';
	$filters = isset($_REQUEST['filter']) ? $_REQUEST['filter'] : null;

	//

	require('./request.php');

	$request = new Request(array('restful' => true));

	//

	$item = Utils::GetRequestParamList (
		array (
			array ( 'name' => 'id',         'type' => 'int'    ),
			array ( 'name' => 'label',      'type' => 'string' ),
			array ( 'name' => 'link_label', 'type' => 'string' ),
			array ( 'name' => 'parent',     'type' => 'int'    ),
		),
		$request
	);

	//

	$article_category_dalc = new ArticleCategory_DALC();

	$parent = $article_category_dalc->GetArticleCategory($item['parent']);

	$item['level'] = 1;

	if (isset($parent)) {

		$item['level'] = $parent['level'] + 1;

	}

	//

	$article_category_dalc->SQL_UpdateItems(
		'article_categories',
		array( $item ),
		array( 'label', 'link_label', 'level', 'parent' )
	);

	echo json_encode(Array(
		"success" => "true"
	));

?>