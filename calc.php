<?php

	// Выбираю города куда возможна доставка

	$url  = "http://emspost.ru/api/rest/?method=ems.get.locations&type=cities&plain=true";
	$json = file_get_contents ( $url );
	$data = json_decode ( $json, TRUE );

	$html_select = '';

	if (isset($data)) {

		if ( $data['rsp']['stat'] == 'fail' ) {

			$html_select = $data['rsp']['err']['code'] . ' - ' . $data['rsp']['err']['msg'];

		} else {

			$html_select = '<select name="select_city">';

			foreach ( $data['rsp']['locations'] as $location ) {

				$html_select .= '<option value="' . $location['value'] . '">' . $location['name'] . '</option>'; 

			}		

			$html_select .= '</select>';

		}
	}
	
	// Максимальный вес

	$url  = "http://emspost.ru/api/rest/?method=ems.get.max.weight";
	$json = file_get_contents ( $url );
	$data = json_decode ( $json, TRUE );

	$html_max_weight = '';

	if (isset($data)) {

		if ( $data['rsp']['stat'] == 'fail' ) {

			$html_max_weight = $data['rsp']['err']['code'] . ' - ' . $data['rsp']['err']['msg'];

		} else {

			$html_max_weight = '<span>Макс. вес</span> : <span>' . $data['rsp']['max_weight'] . '</span>';

		}
	}

?>

<form action = "calc.php" method="post">
	<?php echo $html_select; ?><br />
	<?php echo $html_max_weight; ?><br />
	<span>Вес</span> : <input name="weight" type="text" size="40"/><br />
	<input type="submit" value="Вычислить"></p>
</form>

<?php

	$select_city = '';

	if (isset($_REQUEST['select_city'])) {

		$select_city = $_REQUEST['select_city'];

	}

	$weight = 0;

	if (isset($_REQUEST['weight'])) {

		$weight = $_REQUEST['weight'];

	}

	$html_price = '';
	$html_term = '';

	if ( $select_city && $weight ) {

		$url  = "http://emspost.ru/api/rest?method=ems.calculate&from=city--cheboksary&to=" . $select_city . "&weight=" . $weight;
		$json = file_get_contents ( $url );
		$data = json_decode ( $json, TRUE );

		if (isset($data)) {
	
			if ( $data['rsp']['stat'] == 'fail' ) {
	
				$html_price = $data['rsp']['err']['code'] . ' - ' . $data['rsp']['err']['msg'];
	
			} else {
	
				$html_price = '<span>Стоимость</span> : <span>' . $data['rsp']['price'] . ' руб.</span>';
				$html_term = '<span>Сроки (дни)</span> : <span>' . $data['rsp']['term']['min'] . '..' . $data['rsp']['term']['max'] . '</span>';
	
			}
		}
	}

echo $html_price . '<br />';
echo $html_term;

?>

