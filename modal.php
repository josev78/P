<?php
include ("dll/config.php");
include ("classes/database.php");
extract($_POST);

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Ventana modal</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<link rel="stylesheet" href="<?=$url_site?>css/estilos.css">
	</head>
	<body>
		<div class="contenedor">
			<a href="#openmodal" class="open">Abrir Ventana</a>
			<section id="openmodal" class="modalDialog">
				<section class="modal">
					<a href="#close" class="close"> X </a>
					<h2> Ventana Modal</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati architecto quaerat, facere blanditiis, tempora sequi?</p>
				</section>
			</section>
		</div>
	</body>
</html>