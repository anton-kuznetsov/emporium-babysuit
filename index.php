<?php

	error_reporting(E_ALL ^E_NOTICE);

	ini_set('display_errors',1);

	session_start();

	session_name();

	require_once "var.php";
	require_once "includes/classes.php";

	// Подгружаю шаблон

	$__page_type = "index";

	if (isset($_REQUEST ["t"])) {

		// Возможные варианты
		//  - index   - главная страница
		//  - category
		//  - product - страница товара
		//  - page    - простая информационная страница
		$__page_type = $_REQUEST ["t"];

	}

	if (isset($_REQUEST ["label"])) {

		$__label = $_REQUEST ["label"];

	}

	$__id = 0;

	if (isset($_REQUEST ["id"])) {

		$__id = $_REQUEST ["id"];

	}

	$__id_category = 0;

	if (isset($_REQUEST ["id_category"])) {

		$__id_category = $_REQUEST ["id_category"];

	}

	$__id_product = 0;

	if (isset($_REQUEST ["id_product"])) {

		$__id_product = $_REQUEST ["id_product"];

	}

	$__id_item = 0;

	if (isset($_REQUEST ["id_item"])) {

		$__id_item = $_REQUEST ["id_item"];

	}

	$__qty = 0;

	if (isset($_REQUEST ["qty"])) {

		$__qty = $_REQUEST ["qty"];

	}

	$__size = '';

	if (isset($_REQUEST ["size"])) {

		$__size = $_REQUEST ["size"];

	}

	$__id_brand = 0;

	if (isset($_REQUEST ["id_brand"])) {

		$__id_brand = $_REQUEST ["id_brand"];

	}

	$__id_order = 0;

	if (isset($_REQUEST ["id_order"])) {

		$__id_order = $_REQUEST ["id_order"];

	}

	$__id_shipping_method = 0;
	
	if (isset($_REQUEST ["id_shipping_method"])) {

		$__id_shipping_method = $_REQUEST ["id_shipping_method"];

	}

	$__id_country = 0;
	
	if (isset($_REQUEST ["id_country"])) {

		$__id_country = $_REQUEST ["id_country"];

	}

	$__id_country_region = 0;
	
	if (isset($_REQUEST ["id_country_region"])) {

		$__id_country_region = $_REQUEST ["id_country_region"];

	}

	$__shipping_address = '';
	
	if (isset($_REQUEST ["shipping_address"])) {

		$__shipping_address = $_REQUEST ["shipping_address"];

	}

	$__shipping_params = '';
	
	if (isset($_REQUEST ["shipping_params"])) {

		$__shipping_params = $_REQUEST ["shipping_params"];

	}

	$__id_cart = 0;

	if (isset($_REQUEST ["id_cart"])) {

		$__id_cart = $_REQUEST ["id_cart"];

	}

	$__p = 1;

	if (isset($_REQUEST ["p"]) && ($_REQUEST ["p"] > 0) ) {

		$__p = $_REQUEST ["p"];

	}

	$__limit = 30;

	if (isset($_REQUEST ["limit"]) && ($_REQUEST ["limit"] > 0) ) {

		$__limit = $_REQUEST ["limit"];

	}

	$__order = 'date';

	if (isset($_REQUEST ["order"])) {

		$__order = $_REQUEST ["order"];

	}

	$__page_label = '';

	if (isset($_REQUEST ["label"])) {

		$__page_label = $_REQUEST ["label"];

	}

	$__action = '';

	if (isset($_REQUEST ["action"])) {

		$__action = $_REQUEST ["action"];

	}

	$__fio = '';

	if (isset($_REQUEST ["fio"])) {

		$__fio = $_REQUEST ["fio"];

	}

	$__email = '';

	if (isset($_REQUEST ["email"])) {

		$__email = $_REQUEST ["email"];

	}

	$__phone = '';

	if (isset($_REQUEST ["phone"])) {

		$__phone = $_REQUEST ["phone"];

	}

	$__q = '';

	if (isset($_REQUEST ["q"])) {

		$__q = $_REQUEST ["q"];

	}

	$__select_city = '';

	if (isset($_REQUEST ["select_city"])) {

		$__select_city = $_REQUEST ["select_city"];

	}

	$__weight = '';

	if (isset($_REQUEST ["weight"])) {

		$__weight = $_REQUEST ["weight"];

	}

	$__subject = ''; 

	if (isset($_REQUEST ["subject"])) {

		$__subject = $_REQUEST ["subject"];

	}

	$__text = '';

	if (isset($_REQUEST ["text"])) {

		$__text = $_REQUEST ["text"];

	}

	$__robocassa_out_summ = 0;

	if (isset($_REQUEST ["OutSum"])) {

		$__robocassa_out_summ = $_REQUEST ["OutSum"];

	}


	$__robocassa_inv_id = 0;

	if (isset($_REQUEST ["InvId"])) {

		$__robocassa_inv_id = $_REQUEST ["InvId"];

	}

	$__robocassa_sign_value = '';
	
	if (isset($_REQUEST ["SignatureValue"])) {

		$__robocassa_sign_value = $_REQUEST ["SignatureValue"];

	}

	$page = NULL;

	switch ($__page_type) {

		case 'index':

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				null, //new Slider_UI(),                // Слайдер лучших товаров
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new FeaturedProducts_UI(),      // Рекомендуемые товары
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new HomePage_UI($modules);

			break;

		case 'category':

			$bc_data = array();
			$bc_data["id_category"] = $__id_category;
			$bc_data["page_type"] = $__page_type;

			//
			$cp_data = array();
			$cp_data["id_category"] = $__id_category;
			$cp_data["id_brand"] = $__id_brand;
			$cp_data["p"] = $__p;
			$cp_data["limit"] = $__limit;
			$cp_data["order"] = $__order;

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new Breadcrumbs_UI( Breadcrumbs_UI::BC_TYPE_CATEGORY, $bc_data ), //
				new ContentSlider_UI( $cp_data ), //
				new CategoryInfo_UI( $cp_data ),  //
				new CategoryProducts_UI( $cp_data ),    //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new CategoryPage_UI($modules, $bc_data);

			break;

		case 'search':

			$p_data = array();
			$p_data["q"] = $__q;
			$p_data["p"] = $__p;
			$p_data["limit"] = $__limit;
			$p_data["order"] = $__order;

			// Список подключаемых к странице модулей
			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new SearchResults_UI( $p_data ),    //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new SearchPage_UI($modules);
			break;

		case 'product':

			$bc_data = array();
			$bc_data["id_product"] = $__id_product;

			//
			$pp_data = array();
			$pp_data["id_product"] = $__id_product;

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				null, //new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new Breadcrumbs_UI( Breadcrumbs_UI::BC_TYPE_PRODUCT, $bc_data ), //
				new Product_UI( $pp_data ),    //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new ProductPage_UI($modules, $pp_data);

			//
			$page->action();
			break;

		case 'article':

			$a_data = array();
			$a_data["id_article"] = $__id;
			$a_data["page_type"] = $__page_type;

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new Breadcrumbs_UI( Breadcrumbs_UI::BC_TYPE_ARTICLE, $a_data ), //
				new Article_UI( $a_data ),    //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				null,
				null,
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new CategoryPage_UI($modules, $a_data);
			break;

		case 'article_category':

			$ac_data = array();
			$ac_data["id_article_category"] = $__id;
			$ac_data["page_type"] = $__page_type;

			// Список подключаемых к странице модулей

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new Breadcrumbs_UI( Breadcrumbs_UI::BC_TYPE_ARTICLE_CATEGORY, $ac_data ), //
				new ArticleCategory_UI( $ac_data ),    //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				null,
				null,
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new CategoryPage_UI($modules, $ac_data);
			break;

		case 'page':

			$c_data = array();
			$c_data["page_label"] = $__page_label;

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new InfoPageContent_UI( $c_data ),    //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new InfoPage_UI($modules, $c_data);
			break;

		case 'brand':

			$bp_data = array();
			$bp_data["id_brand"] = $__id_brand;

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new Brand_UI( $bp_data ),       //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new InfoPage_UI($modules, $bp_data);
			break;

		case 'create_order':

			$p_data = array();
			$p_data["action"] = $__action;
			$p_data["id_order"] = $__id_order;
			$p_data["id_cart"] = $__id_cart;
			$p_data["id_shipping_method"] = $__id_shipping_method;
			$p_data["id_country"] = $__id_country;
			$p_data["id_country_region"] = $__id_country_region;
			$p_data["shipping_address"] = $__shipping_address;
			$p_data["shipping_params"] = $__shipping_params;
			$p_data["fio"] = $__fio;
			$p_data["email"] = $__email;
			$p_data["phone"] = $__phone;

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new CreateOrder_UI( $p_data ),  //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new CreateOrderPage_UI($modules, $p_data);

			//
			$page->action();

			//
			break;

		case 'cart':

			$cp_data = array();
			$cp_data["action"] = $__action;
			$cp_data["id_product"] = $__id_product;
			$cp_data["id_item"] = $__id_item;
			$cp_data["qty"] = $__qty;
			$cp_data["size"] = $__size;

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				// Content
				new ShopingCart_UI(), //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы
			$page = new CartPage_UI($modules, $cp_data);

			//
			$page->action();

			//
			break;

		case 'delivery_calc':

			$p_data = array();
			$p_data["action"] = $__action;
			$p_data["select_city"] = $__select_city;
			$p_data["weight"] = $__weight;

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				new DeliveryCalc_UI( $p_data ),  //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             // 
			);

			// Генератор страницы	
			$page = new DeliveryCalcPage_UI($modules, $p_data);

			//
			//$page->action();

			//
			break;

		case 'send_message':

			$p_data = array();
			$p_data["action"] = $__action;
			$p_data["id"] = $__id;
			$p_data["fio"] = $__fio;
			$p_data["email"] = $__email;
			$p_data["phone"] = $__phone;
			$p_data["subject"] = $__subject;
			$p_data["text"] = $__text;

			//

			$modules = array (
				new TopMenu_UI(),               //
				new ModalCart_UI(),				//
				new ProductScroller_UI(),       //
				// Content
				new SendMessage_UI( $p_data ),  //
				//
				null, //new BrandSideMenu_UI(),         //
				null, //new AccessoriesSideMenu_UI(),	//
				new ColumnCart_UI(),            //
				null, //new Newsletter_UI(),            //
				null, //new ColumnCompareProducts_UI(), //
				//
				new ProductFooterViewed_UI(),   // 
				null, //new BrandFooterViewed_UI(),     //
				//
				new NewFooterList_UI(),         //
				new BestsellerFooterList_UI(),  //
				new PopularFooterList_UI(),     //
				//
				new FooterMenu_UI()             // 
			);

			//	
			$page = new SendMessagePage_UI($modules, $p_data);

			//
			$page->action();

			//
			break;

		case 'success_payment':

			$p_data = array();
			$p_data["sum"]      = $__robocassa_out_summ;
			$p_data["id_order"] = $__robocassa_inv_id;
			$p_data["crc"]      = $__robocassa_sign_value;

			//

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				null, //
				new SuccessPayment_UI( $p_data ),  //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				null, //
				null, //
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             //
			);

			//	
			$page = new InfoPage_UI($modules, $p_data);

			//
			break;

		case 'fail_payment':

			$modules = array (
				new TopMenu_UI(),               // Верхнее меню
				new ModalCart_UI(),				// Ссылка и модальная форма Корзины
				new ProductScroller_UI(),       // Прокрутка "Карусель" товаров
				// Content
				null, //
				new FailPayment_UI(),           //
				// Левая колонка
				null, //new BrandSideMenu_UI(),         // Меню по брендам
				null, //new AccessoriesSideMenu_UI(),	// Меню по аксессуарам
				new ColumnCart_UI(),            // Мини-таблица "Корзина"
				null, //new Newsletter_UI(),            // Регистрация на рассылку новостей по электронной почте
				null, //new ColumnCompareProducts_UI(), // Мини-таблица "Сравнение товаров"
				null, //
				null, //
				// Подвал № 1
				new ProductFooterViewed_UI(),   // Последние просмотренные товары 
				null, //new BrandFooterViewed_UI(),     // Брэнды
				// Подвал № 2
				new NewFooterList_UI(),         // Список "Новинки" (по дате публикации в магазине)
				new BestsellerFooterList_UI(),  // Список "Самые покупаемые товары"
				new PopularFooterList_UI(),     // Список "Самые популярные товары"
				// Подвальное меню
				new FooterMenu_UI()             //
			);

			//	
			$page = new InfoPage_UI($modules, null);

			//
			break;

	}

	// Вывод страницы
	$page->render();

?>