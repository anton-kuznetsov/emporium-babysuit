<?php

ini_set("max_execution_time", "3600");

$a = array(
	array( 1.07, 1 ),  #0 
	array( 1.21, 1 ),  #1
	array( 1.04, 1 ),  #2
	array( 1.153, 1 ), #3
	array( 1.125, 1 ), #4
	array( 1.085, 0 ), #5
	array( 1.095, 1 ), #6
	array( 1.085, 1 ), #7
	array( 1.32, 1 )   #8
);

$b = array();
$b_qty = 1;

for ( $j = 1; $j < count($a); $j++ ) {

	$b[''.$b_qty] = array(
		'str'  => '0,' . $j,
		'path' => array ( '0' => 0, '' . $j => $j ),
		'koef' => 1.0 / ( $a[0][0] * $a[$j][0] ),
		'end'  => $j,
		'i'    => $b_qty
	);

	$b_qty++;

}

$iteration_qty = 1;

echo count($b) . '<br />';

while ( 1 == 1 ) {

	echo 'iteration: ' . $iteration_qty . '<br />';
	$iteration_qty++;

	$v = 100;
	$vk = -1;

	// поиск минимума
	foreach($b as $bi) {

		if ( $v > $bi['koef'] ) {

			$v = $bi['koef'];
			$vk = $bi['i'];
		
		}
	}

	if ( count($b[''.$vk]['path']) == 8 ) {

		echo 'min_val => ' . $b[''.$vk]['koef'] . '<br />';
		echo 'min => ' . count($b[''.$vk]['path']) . '<br />';
		echo 'str => ' . $b[''.$vk]['str'] . '<br />';

		foreach ($b[''.$vk]['path'] as $bb) {

			echo $bb . '-';

		}

		echo '<br />';

		break;

	}

	// $vk - идентификатор минимального коэффициента

	$str = $b[''.$vk]['str'];
	$koef = $b[''.$vk]['koef'];
	$end = $b[''.$vk]['end'];

	for ( $j = 1; $j < count($a); $j++ ) {

		$path = $b[''.$vk]['path'];

		if ( ! array_key_exists(''.$j, $path) ) {

			$path[''.$j] = $j;

			$b[''.$b_qty] = array(
				'str'  => $str . ',' . $j,
				'path' => $path,
				'koef' => $koef + 1 / ( $a[$end][0] * $a[$j][0] ),
				'end'  => $j,
				'i'    => $b_qty,
			);
			
			$b_qty++;

		}
	}
	
	unset($b[''.$vk]);

}

//

$v = 100;
$vk = -1;

// поиск минимума
foreach($b as $bi) {

	if ( $v > $bi['koef'] ) {

		$v = $bi['koef'];
		$vk = $bi['i'];
	
	}
}

$str = $b[''.$vk]['str'];
$path = $b[''.$vk]['path'];

echo '<br />result<br />';
echo $str . '<br />';
echo 'koef = ' . $koef;

?>