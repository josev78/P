<?php
include ("dll/config.php");
include ("classes/database.php");
extract($_GET);
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
		<h3>Nuevo Producto</h3>
			<form action="productos.php" method="post" accept-charset="utf-8">
				<div class="form-group">
					<label for="nombre">Nombre producto *</label>
					<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del producto" required>
					<input type="hidden" name="var" value="2">
				</div>
				</br>
				<button type="submit" class="btn btn-default">Guardar</button>
			</form>

		<h3>Listado de Productos</h3>
			<?php
				$database = new Database();
				//verificar si ya existe la nombre
				if (isset($nombre))
				{
					$database->query('SELECT * FROM productos WHERE nombre = :nombre');
					$database->bind(':nombre',$nombre);
					$existe = $database->resultset();
					if ($existe != null)
					{
						echo 'nombre ya existe';
						$nombre = '';
					} 
					elseif (isset($var) && $var==2) //Seccion para insertar registro
					{
						$database->query('INSERT INTO productos (nombre) VALUES(:nombre)');
						$database->bind(':nombre',$nombre);
						$database->execute();
						echo "<script>location.href='productos.php'</script>";
					}
				}
				//Presentar el listado
				$database->query('SELECT * FROM productos');
				$rows = $database->resultset();
				if ($rows != null)
				{
					echo "<table class='table'>";
					echo "<th>Id</th>";
					echo "<th>Nombre</th>";
					echo "<th>Opcion</th>";
				}
				foreach ($rows as $row) 
				{
					echo "<tr>";
					foreach ($row as $col) 
					{
						echo "<td>$col</td>";
					}
					echo "<td><a href='productos.php?var=1&id=$row[Id]' class='borrar'><span title='Eliminar este registro' class='icon-trashcan'></span></a></td>";
					echo "</tr>"; 
				}
				echo "</table>";
				//Seccion para eliminar registro
				if (isset($var) && $var==1) 
				{
					$database->query('delete from productos where id=:id');
					$database->bind(':id',$id);
					$database->execute();
					echo "<script>location.href='productos.php'</script>";
				}
			?>
		
	</div>
	<?php include ("piepagina.php"); ?>
</body>