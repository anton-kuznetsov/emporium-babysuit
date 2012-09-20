<?php

	// Подключение к базе MySQL
	$db_login = 'root';
	$db_pass  = '';
	$db_host  = 'localhost';
	$db_name  = 'babysuit';

	// URL админки
	$site_url = 'http://localhost/babysuit/adminka/';

	// Каталог админки
	$site_folder = $_SERVER['DOCUMENT_ROOT'] . '/babysuit/adminka/';

	// Заголовок
	$site_title = 'Система управления интернет-магазином Baby-Suit.Ru';

	//------------------------------------------------------------------------------------------

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

	$site_counters = '';

?>