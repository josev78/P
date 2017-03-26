<?php
include ("dll/config.php");
include ("classes/database.php");
extract($_POST);
extract($_GET);

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
    		<li><a href="<?=$url_site?>facturacion.php">Regresar</a></li>
  		</ul>
	</div>
	<div class="contenido">
		<form action="facturaciondetalle.php" method="post" accept-charset="utf-8">
		<h4>Detalle de Venta</h4>
			<div class="form-group">
				<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $idFactura; ?>" required>
			</div>
			<div class="form-group">
				<label for="producto">Producto:</label>
				<select name="producto" id="producto" required>
					<option value=""></option>
				  	<?php
				  		$database = new Database();
						$database->query('SELECT * FROM Productos');
						$rows = $database->resultset();
						foreach ($rows as $row) 
						{ ?>
							<option value="<?php echo $row['Id'];?>"><?php echo $row['Nombre'];?></option><?PHP
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="cantidad">Cantidad:</label>
				<input type="text" class="form-control" id="cantidad" name="cantidad" placeholder="Cantidad" required>
			</div>
			<div class="form-group">
				<label for="valor">Valor:</label>
				<input type="text" class="form-control" id="valor" name="valor" placeholder="valor" required>
			</div>
			</br>
			<input type="submit" name="insertar" class="btn btn-default" value="Agregar"/>
		</form>

		<h3>Detalle de Productos</h3>
			<?php
				$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				if ($idFactura != null)
					$idVenta = $idFactura;
				elseif ($post['id'] != null)
					$idVenta = $post['id'];
				else
					$idVenta = $post['idFact'];
				$idProducto = $post['producto'];
				$cantidad = $post['cantidad'];
				$valor = $post['valor'];
				$database = new Database();
				if ($post['insertar']) //Seccion para insertar registro
				{
					$database->query('INSERT INTO VENTAS_DETALLE (IdVenta, IdProducto, Cantidad, Valor) VALUE (:IdVenta, :IdProducto, :Cantidad, :Valor)');
					$database->bind(':IdVenta', $idVenta );
					$database->bind(':IdProducto', $producto);
					$database->bind(':Cantidad', $cantidad);
					$database->bind(':Valor', $valor);
					$database->execute();
					//$idFactura = $database->lastInsertId();
					echo "<script>location.href='facturaciondetalle.php?idFactura=".$idVenta."'</script>";
				}
				//Presentar el listado
				$database->query('SELECT VD.Id, P.Nombre, VD.Cantidad, VD.Valor, (VD.Cantidad * VD.Valor) Total FROM ventas_detalle VD 
					INNER JOIN productos P ON P.Id = VD.IdProducto 
					WHERE VD.IdVenta = :IdVenta ORDER BY VD.Id DESC');
				$database->bind(':IdVenta', $idVenta);
				$rows = $database->resultset();
				if ($rows != null)
				{
					echo "<table class='table'>";
					echo "<th>Id</th>";
					echo "<th>Producto</th>";
					echo "<th>Cantidad</th>";
					echo "<th>Valor</th>";
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
					echo "<form method='post' action='facturaciondetalle.php'>";
					echo "<td><input type='hidden' name='eliminar_id' value='".$row['Id']."'>";
					echo "<input type='hidden' name='idFact' value='".$idVenta."'>";
					echo "<input type='submit' name='eliminar' value='Eliminar' /></td>";
					echo "</form>";
					echo "</tr>"; 
				}
				$database->query('SELECT SUM(VD.Cantidad * VD.Valor) Total FROM ventas_detalle VD 
					INNER JOIN productos P ON P.Id = VD.IdProducto 
					WHERE VD.IdVenta = :IdVenta ORDER BY VD.Id DESC');
				$database->bind(':IdVenta', $idVenta );
				$totalFactura = $database->devolverFila();
				if ($totalFactura != null)
				{
					echo "<tr class='tabla-resultado'>";
					echo "<td></td><td></td><td>Total:</td><td></td>";
					echo "<td>$totalFactura[0]</td>";
					echo "</tr>"; 
					echo "</table>";
				}
				//Seccion para eliminar registro
				if ($post['eliminar'])
				{
					$delete_id = $post['eliminar_id'];
					$database->query('delete from ventas_detalle where id=:id');
					$database->bind(':id',$delete_id);
					$database->execute();
					echo "<script>location.href='facturaciondetalle.php?idFactura=".$idVenta."'</script>";
				}
			?>
	</div>
	<?php include ("piepagina.php"); ?>
</body>