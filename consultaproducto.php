<?php
include ("dll/config.php");
include ("classes/database.php");
extract($_POST);

?>
<head>
	<meta charset="utf-8">
	<title><?php echo $site_name; ?></title>
	<link rel="stylesheet" href="<?=$url_site?>css/estilo_menuvertical.css">
	<link rel="stylesheet" href="<?=$url_site?>img/style.css">
</head>
<body>
	<?php include ("encabezadopagina.php"); ?>
	<div class="contenido">
		<form action="consultaproducto.php" method="post" accept-charset="utf-8">
			<div class="form-group">
				<label for="id">Id Producto *</label>
				<input type="text" id="id" name="id" required>
			</div>
			</br>
			<input type="submit" name='consultar' value='Consultar' class="btn btn-default" />
		</form>
		<h3>Listado de Clientes</h3>
			<?php
				$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$valor = $post['id'];
				if ($valor != null)
				{
					$database = new Database();
					$database->query('CALL devuelveValorProducto(:valor,@resultado)');
					$database->bindParam(':valor', $valor);
					$database->execute();
					$database->query('SELECT @resultado');
					$resultado = $database->devolverFila();
					echo $resultado[0];
				}
			?>
	</div>
	<?php include ("piepagina.php"); ?>
</body>