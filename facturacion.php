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
		<h3>Nueva Venta</h3>
			<form action="facturacion.php" method="post" accept-charset="utf-8">
				<div class="form-group">
					<label for="fecha">Fecha *</label>
					<input type="datetime-local" value="<?php echo date('Y-m-d'); ?>" id="fecha" name="fecha" required>
				</div>
				<div class="form-group">
					<label for="cliente">Cliente *</label>
					<select name="cliente" id="cliente" required>
						<option value=""></option>
					  	<?php
					  		$database = new Database();
							$database->query('SELECT * FROM Clientes');
							$rows = $database->resultset();
							foreach ($rows as $row) 
							{ ?>
								<option value="<?php echo $row['Id'];?>"><?php echo $row['Nombres'];?></option><?PHP
							}
						?>
					</select> 
				</div>
				<div class="form-group">
					<label for="observacion">Observacion</label>
					<textarea name="observacion" ide="observacion" rows="3" cols="50"></textarea> 
				</div>
				</br>
				<input type="submit" name='insertar' value='Insertar' class="btn btn-default" />
			</form>

		<h3>Listado de Ventas</h3>
			<?php
				$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$fecha = $post['fecha'];
				$idCliente = $post['cliente'];
				$observacion = $post['observacion'];
				$database = new Database();
				if ($post['insertar']) //Seccion para insertar registro
				{
					$database->query('INSERT INTO VENTAS (Fecha, IdCliente, Observacion) VALUE (:Fecha, :IdCliente, :Observacion)');
					$database->bind(':Fecha', $fecha);
					$database->bind(':IdCliente', $idCliente);
					$database->bind(':Observacion', $observacion);
					$database->execute();
					//$idFactura = $database->lastInsertId();
					echo "<script>location.href='facturacion.php'</script>";
				}
				//Presentar el listado
				$database->query('SELECT V.Id, V.Fecha, C.Nombres, V.Total FROM ventas V 
					INNER JOIN clientes C ON C.Id = V.IdCliente ORDER BY V.Id DESC');
				$rows = $database->resultset();
				if ($rows != null)
				{
					echo "<table class='table'>";
					echo "<th>Id</th>";
					echo "<th>Fecha</th>";
					echo "<th>Nombres</th>";
					echo "<th>Total</th>";
				}
				foreach ($rows as $row) 
				{
					echo "<tr>";
					foreach ($row as $col) 
					{
						echo "<td>$col</td>";
					}
					//echo "<td><a href='clientes.php?var=1&id=$row[Id]' class='borrar'><span title='Eliminar este registro' class='icon-trashcan'></span></a></td>";
					echo "<form method='post' action='facturacion.php'>";
					echo "<td><input type='hidden' name='eliminar_id' value='".$row['Id']."'>";
					echo "<input type='submit' name='eliminar' value='Eliminar' />";
					echo "<input type='submit' name='detalle' value='Detalle' /></td>";
					echo "</form>";
					echo "</tr>"; 
				}
				echo "</table>";
				//Seccion para eliminar registro
				if ($post['eliminar'])
				{
					echo "<script>location.href='modal.php'</script>";
					/*
					$delete_id = $post['eliminar_id'];
					$database->query('delete from ventas where id=:id');
					$database->bind(':id',$delete_id);
					$database->execute();
					*/
					//echo "<script>location.href='facturacion.php'</script>";
				}
				if ($post['detalle'])
				{
					echo "<script>location.href='facturaciondetalle.php?idFactura=".$post['eliminar_id']."'</script>";
				}
			?>
		
	</div>
	<?php include ("piepagina.php"); ?>
