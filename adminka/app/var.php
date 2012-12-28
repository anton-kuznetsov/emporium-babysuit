<?php

	// Подключение к базе MySQL
	$db_login = 'root';
	$db_pass  = '';
	$db_host  = 'localhost';
	$db_name  = 'babysuit';

	// URL's
	$SITE_URL    = 'http://localhost/babysuit/';
	$ADMINKA_URL = $SITE_URL . 'adminka/';

	// Каталог админки
	$SITE_FOLDER    = $_SERVER['DOCUMENT_ROOT'] . '/babysuit/';
	$ADMINKA_FOLDER = $SITE_FOLDER . 'adminka/';

	// URL's UPLOAD
	$UPLOAD_URL          = $SITE_FOLDER . 'upload/';
	$ORIGINAL_UPLOAD_URL = $UPLOAD_URL . 'original/';
	$FULL_UPLOAD_URL     = $UPLOAD_URL . 'full/';
	$THUMBS_UPLOAD_URL   = $UPLOAD_URL . '250x250/';
	$90x90_UPLOAD_URL    = $UPLOAD_URL . '90x90/';
	$78x78_UPLOAD_URL    = $UPLOAD_URL . '78x78/';
	$50x50_UPLOAD_URL    = $UPLOAD_URL . '50x50/';

	// Каталоги UPLOAD
	$UPLOAD_FOLDER          = $SITE_FOLDER . 'upload/';
	$ORIGINAL_UPLOAD_FOLDER = $UPLOAD_FOLDER . 'original/';
	$FULL_UPLOAD_FOLDER     = $UPLOAD_FOLDER . 'full/';
	$THUMBS_UPLOAD_FOLDER   = $UPLOAD_FOLDER . '250x250/';
	$90x90_UPLOAD_FOLDER    = $UPLOAD_FOLDER . '90x90/';
	$78x78_UPLOAD_FOLDER    = $UPLOAD_FOLDER . '78x78/';
	$50x50_UPLOAD_FOLDER    = $UPLOAD_FOLDER . '50x50/';

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