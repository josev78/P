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
	<div id="button">
  		<ul><p>Menu Opciones</p>
    		<li><a href="<?=$url_site?>index.php">Regresar</a></li>
  		</ul>
	</div>
	<div class="contenido">
		
		<h3>Listado de Ventas</h3>
			<?php
				$database = new Database();
				//Presentar el listado
				$database->query('SELECT V.Id, V.Fecha, C.Nombres, V.Total FROM ventas V 
					INNER JOIN clientes C ON C.Id = V.IdCliente ORDER BY V.Id DESC');
				$rows = $database->resultset();
				if ($rows != null)
				{
					echo "<form action='listado.php' method='post' accept-charset='utf-8'>";
					echo "</br>";
					echo "<input type='submit' name='calcular' value='Calcular' class='btn btn-default' />";
					echo "<table class='table'>";
					echo "<th>Id</th>";
					echo "<th>Fecha</th>";
					echo "<th>Nombres</th>";
					echo "<th>Total</th>";
					echo "<th>Seleccionar</th>";
				}
				foreach ($rows as $row) 
				{
					echo "<tr>";
					foreach ($row as $col) 
					{
						echo "<td>$col</td>";
					}
					echo "<td><input type='checkbox' name='seleccionar[]' value='".$row['Id']."' /></td>";
					echo "</tr>"; 
				}
				echo "</table>";
				echo "</form>";
			?>
		
	</div>
	<?php include ("piepagina.php"); ?>
</body>
<?php
	$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	if ($post['calcular'])
	{
		$conjunto = $post['seleccionar'];
		$total = count($conjunto);
		for ($i = 0; $i < $total; $i++) {
			echo $conjunto[$i] . '</br>';
		}
		echo "<script>location.href='otro.php?Seleccionados=".serialize($conjunto)."'</script>";
	}

?>