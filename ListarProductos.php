<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Listado de Productos</title>
</head>
<body>
<form name="frmlistarproductos" method="post" action="ListarProductos.php">
	<table align="center">
		<tr>
			<td>Fecha Inicial:</td>
			<td><input type="date" name="txtdesde" required autocomplete="off" /></td>
		</tr>
		<tr>	
			<td>Fecha Final:</td>
			<td><input type="date" name="txthasta" required autocomplete="off" /></td>
		</tr>
		<tr>				
			<td colspan="2"><input type="submit" name="btnlistar" value="LISTAR PRODUCTOS" /></td>
		</tr>
	</table>
</form>
</body>
</html>
<?php
if(isset($_POST["btnlistar"])){
	$desde=$_POST["txtdesde"];
	$hasta=$_POST["txthasta"];
	$contenido=file_get_contents("http://localhost:8090/FiltrarFechas?desde=".$desde."&hasta=".$hasta);
	$reg=json_decode($contenido,true);
	?>
	<center>
		<fieldset style="width: 80%;">
			<legend>Listado de Productos:</legend>
			<table align="center" border="1" cellpadding="3" cellspacing="0">
				<tr>
					<td>C&oacute;digo del Producto</td>
					<td>Categoria</td>
					<td>Descripci&oacute;n del Producto</td>
					<td> Precio de Venta</td>
					<td>Stock</td>
					<td>Fecha de Registro</td>
				</tr>
				<?php
					foreach ($reg as $valor) {
						echo("<tr>");
						echo("<td>".$valor['codpro']."</td>");
						echo("<td>".$valor['codcat']."</td>");
						echo("<td>".$valor['despro']."</td>");
						echo("<td style='text-align:right'>".number_format($valor['pvepro'],2)."</td>");
						echo("<td style='text-align:right'>".number_format($valor['stopro'],2)."</td>");
						echo("<td>".$valor['frepro']."</td>");
						echo("</tr>");
					}
				?>
			</table>
		</fieldset>
	</center>	
	<?php
}
?>