<?php

	$sitepath = 'http://baby-suit.ru/adminka/';

	$id = 0;

	if (isset($_REQUEST ["id"])) {

		$id = $_REQUEST ["id"];

	}

	if (! isset($_REQUEST ["noframe"])) {

?>

<iframe src='<?php echo $sitepath; ?>wgt_karusel.php?noframe=1&id=<?php echo $id; ?>' width="100%" height="100%"></iframe>

<?php

	} else {

?>

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta http-equiv="Expires" content="-1">
		<meta http-equiv="Cache-Control" content="No-Cache">
		<meta http-equiv="pragma" content="no-cache">

		<title>Baby-Suit.Ru :: ���������� �������</title>

		<link rel="stylesheet" type="text/css" href="extjs/resources/css/ext-all.css">

		<link rel="stylesheet" type="text/css" href="resources/css/style.css">

    	<script type="text/javascript" src="extjs/ext-all-debug.js"></script>
		<script type="text/javascript" src="utils.js"></script>

<?php

	if ( $id ) {

?>

		<script type="text/javascript">

			var request_param_id = <?php echo $id; ?>;

		</script>

    	<script type="text/javascript" src="wgt_karusel/form.js"></script>

    	<script type="text/javascript" src="wgt_karusel/form_app.js"></script>

<?php

	} else {

?>

		<script type="text/javascript">

		</script>

    	<script type="text/javascript" src="wgt_karusel/grid.js"></script>

    	<script type="text/javascript" src="wgt_karusel/grid_app.js"></script>

<?php

	}

?>

	</head>
	<body>

	</body>
</html>

<?php

	}

?>