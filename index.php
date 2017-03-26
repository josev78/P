<?php
require 'dll/config.php';
?>
<head>
	<meta charset="utf-8">
	<title><?php echo $site_name; ?></title>
	<link rel="stylesheet" href="<?=$url_site?>css/estilo_menuvertical.css">
</head>
<?php include ("encabezadopagina.php"); ?>
	<div id="button">
  		<ul><p>Menu Opciones</p>
    		<li><a href="<?=$url_site?>clientes.php">Clientes</a></li>
    		<li><a href="<?=$url_site?>productos.php">Productos</a></li>
    		<li><a href="<?=$url_site?>facturacion.php">Facturacion</a></li>
    		<li><a href="<?=$url_site?>consultaproducto.php">Consulta</a></li>
  		</ul>
	</div>
	<div class="contenido">
		<h3>Titulo</h3>
			<p>Contenido sadas dasdsad asdasdsadsa sadasdasd sdasdasd sdasdsads sadsa
			sadasdasdsad dsdasdsadsadsad sdasdasdas asdsadasdasd sdasdas sadsd sdsad as
			sadsadsad sdadsad d sadsadsadsad sadsd s sdsad asd sdsadsadsad</p>
	</div>
<?php include ("piepagina.php"); ?>
