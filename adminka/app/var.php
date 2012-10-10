<?php

	error_reporting (E_ERROR);
	$n = getenv('REQUEST_URI');

	//

	if (!eregi('(',$n) and !eregi('(',$n) and !eregi(',',$n) and !eregi('+',$n) and !eregi(':',$n) and !eregi('http',$n) and !eregi('ftp',$n) and !eregi('"',$n) and !eregi("'",$n) and !eregi('<',$n) and !eregi('>',$n) and !eregi('[',$n) and !eregi(']',$n) and !eregi('{',$n) and !eregi('}',$n)) {

		// MySQL
		// логин
		$bdlogin = 'u131563';
		// пароль
		$bdpass  = 'karateka21';
		// имя хоста
		$bdhost  = 'idb2.majordomo.ru';
		// имя базы данных
		$bdname  = 'b131563_baby';

		// Robocassa
		$robocassa_login = 'test_babysuit';
		$robocassa_pass1 = 'FMwn81TmTy';
		$robocassa_pass2 = '411EiH5j9S';

		$folder_root = $_SERVER['DOCUMENT_ROOT'];
		$site_root = 'http://babysuit.seo-cheb.ru/';
		
		$adminka_root = 'http://babysuit.seo-cheb.ru/';

	}

?>