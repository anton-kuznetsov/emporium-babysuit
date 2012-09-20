<?php
// следующие две строки не редактировать
error_reporting (E_ERROR);
$n = getenv('REQUEST_URI');

if (!eregi('(',$n) and !eregi('(',$n) and !eregi(',',$n) and !eregi('+',$n) and !eregi(':',$n) and !eregi('http',$n) and !eregi('ftp',$n) and !eregi('"',$n) and !eregi("'",$n) and !eregi('<',$n) and !eregi('>',$n) and !eregi('[',$n) and !eregi(']',$n) and !eregi('{',$n) and !eregi('}',$n)) {
// предыдущие две строки не редактировать


// логин для подключения к базе MySQL
$bdlogin = 'root';

// пароль для подключения к базе MySQL
$bdpass = '';

// имя хоста MySQL
$bdhost = 'localhost';

// общее имя базы данных
$bdname = 'shwei';

// имя таблицы для товаров
$textable = 'itemslist';

// имя таблицы для параметров денежных единиц
$valtable = 'valute';

// имя таблицы для заполнения корзины
$ordertable = 'orderlist';

// имя таблицы для установок магазина
$admintable = 'adminip';

// имя таблицы для новостей
$newstable = 'news';

// имя таблицы для отзывов к товарам
$commentstable = 'comment';

// имя таблицы для списка способов оплаты
$paytable = 'pay';

// имя таблицы для списка способов доставки
$gotable = 'go';

// имя таблицы для списка заказов
$offerordertable = 'ordered';

// имя таблицы для email адресов (рассылка)
$emailr = 'sendlist';

// имя таблицы для параметров рассылки
$rassilka = 'rparam';

// имя таблицы для справки по магазину
$helptable = 'help';

// Параметр для работы корзины. "ip" - по IP-адресу клиента, "session" - используются сессии.
$ident = 'ip';

// e-mail владельца магазина (администратора)
$adminemail = '';

// максимальный размер фотографий и файлов excel (в байтах, 1 Кб=1024 байта)
$MAX_FILE_SIZE = 200000;

// путь к www-директории сайта на сервере (для загрузки фото, уточните у администратора сервера
$upath = '';

// каталог для фотографий
$photodir = 'photos/';

// каталог для прайсов в формате excel
$exceldir = 'excel/';

// адрес сайта (без "/" (слэша) в конце)
$siteadress = 'http://localhost/bs';

// название сайта
$sitename = 'BabySuit.ru';

// цвет ссылок
$linkcolor = '#0000ff';

// цвет ссылок при наведении
$linkhover = '#ff33cc';

// основной цвет таблиц
$maincolor = '#F7F7F7';

// дополнительный цвет таблиц
$altcolor = '#e5eaf5';

// цвет рамки таблиц
$bordercolor = '#9966CC';

//------------------------------------------------------------------------------

$folder_root = $_SERVER['DOCUMENT_ROOT'] . '/bs';
$site_root = 'http://localhost/bs/';

$week_days_rus = array ( 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье' );

$month_rus = array ( 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря' );

$site_counters = '';

}
?>