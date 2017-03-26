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
	<div style="position: absolute; width: 650px; height: 450px; left: 210px; top: 80px">
		<h3>Nuevo Cliente</h3>
			<form action="clientes.php" method="post" accept-charset="utf-8">
				<div class="form-group">
					<label for="cedula">Cedula *</label>
					<input type="text" class="form-control" id="cedula" name="cedula" placeholder="Cedula" required>
					<input type="hidden" name="var" value="2">
				</div>
				<div class="form-group">
					<label for="nombres">Nombres y Apellidos *</label>
					<input type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres y apellidos" required>
				</div>
				</br>
				<button type="submit" class="btn btn-default">Guardar</button>
			</form>

		<h3>Listado de Clientes</h3>
			<?php
				$database = new Database();
				//verificar si ya existe la cedula
				if (isset($cedula))
				{
					$database->query('SELECT * FROM clientes WHERE cedula = :cedula');
					$database->bind(':cedula',$cedula);
					$existe = $database->resultset();
					if ($existe != null)
					{
						echo 'cedula ya existe';
						$cedula = '';
					} 
					elseif (isset($var) && $var==2) //Seccion para insertar registro
					{
						$database->query('INSERT INTO clientes (cedula, nombres) VALUES(:cedula,:nombres)');
						$database->bind(':cedula',$cedula);
						$database->bind(':nombres',$nombres);
						$database->execute();
						echo "<script>location.href='clientes.php'</script>";
					}
				}
				//Presentar el listado
				$database->query('SELECT * FROM clientes');
				$rows = $database->resultset();
				if ($rows != null)
				{
					echo "<table class='table'>";
					echo "<th>Id</th>";
					echo "<th>Cedula</th>";
					echo "<th>Nombres</th>";
					echo "<th>Opcion</th>";
				}
				foreach ($rows as $row) 
				{
					echo "<tr>";
					foreach ($row as $col) 
					{
						echo "<td>$col</td>";
					}
					echo "<td><a href='clientes.php?var=1&id=$row[Id]' class='borrar'><span title='Eliminar este registro' class='icon-trashcan'></span></a></td>";
					echo "</tr>"; 
				}
				echo "</table>";
				//Seccion para eliminar registro
				if (isset($var) && $var==1) 
				{
					$database->query('delete from clientes where id=:id');
					$database->bind(':id',$id);
					$database->execute();
					echo "<script>location.href='clientes.php'</script>";
				}
			?>
		
	</div>
	<?php include ("piepagina.php"); ?>
</body>