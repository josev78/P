<?php
extract($_GET);
	$conjunto = unserialize($_GET['Seleccionados']);
		$total = count($conjunto);
		for ($i = 0; $i < $total; $i++) {
			echo $conjunto[$i] . '</br>';
		}
?>