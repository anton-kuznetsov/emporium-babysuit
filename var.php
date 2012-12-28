<?php

	error_reporting (E_ERROR);
	$n = getenv('REQUEST_URI');

	//

	if (!eregi('(',$n) and !eregi('(',$n) and !eregi(',',$n) and !eregi('+',$n) and !eregi(':',$n) and !eregi('http',$n) and !eregi('ftp',$n) and !eregi('"',$n) and !eregi("'",$n) and !eregi('<',$n) and !eregi('>',$n) and !eregi('[',$n) and !eregi(']',$n) and !eregi('{',$n) and !eregi('}',$n)) {

		// MySQL
		$bdlogin = 'artem145_bsuit';
		$bdpass  = '3vkHNb3S';
		$bdhost  = 'localhost';
		$bdname  = 'artem145_babysuit';

		// Robocassa
		$robocassa_login = 'test_babysuit';
		$robocassa_pass1 = 'FMwn81TmTy';
		$robocassa_pass2 = '411EiH5j9S';

		// название сайта
		$sitename = 'Интернет-магазин карнавальных костюмов для малышей';

		$folder_root = $_SERVER['DOCUMENT_ROOT'];
		$site_root = 'http://babysuit.seo-cheb.ru/';

		$week_days_rus = array (
			'Понедельник',
			'Вторник',
			'Среда',
			'Четверг',
			'Пятница',
			'Суббота',
			'Воскресенье'
		);

		$month_rus = array (
			'января',
			'февраля',
			'марта',
			'апреля',
			'мая',
			'июня',
			'июля',
			'августа',
			'сентября',
			'октября',
			'ноября',
			'декабря'
		);

		$site_counters = '<!-- Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->';

	}

?>