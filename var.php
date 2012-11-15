<?php

	error_reporting (E_ERROR);
	$n = getenv('REQUEST_URI');

	//

	if (!eregi('(',$n) and !eregi('(',$n) and !eregi(',',$n) and !eregi('+',$n) and !eregi(':',$n) and !eregi('http',$n) and !eregi('ftp',$n) and !eregi('"',$n) and !eregi("'",$n) and !eregi('<',$n) and !eregi('>',$n) and !eregi('[',$n) and !eregi(']',$n) and !eregi('{',$n) and !eregi('}',$n)) {

		// MySQL
		$bdlogin = 'u131563';
		$bdpass  = 'karateka21';
		$bdhost  = 'idb2.majordomo.ru';
		$bdname  = 'b131563_baby';

		// Robocassa
		$robocassa_login = 'test_babysuit';
		$robocassa_pass1 = 'FMwn81TmTy';
		$robocassa_pass2 = '411EiH5j9S';

		// название сайта
		$sitename = 'Интернет-магазин карнавальных костюмов для малышей';

		$folder_root = $_SERVER['DOCUMENT_ROOT'];
		$site_root = 'http://baby-suit.ru/';

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

		$site_counters =
'<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter16921918 = new Ya.Metrika({id:16921918, enableAll: true});
        } catch(e) { }
    });
    
    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/16921918" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->';

	}

?>