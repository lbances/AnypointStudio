<?php 
session_start();
$usuario=$_SESSION['us'];
$clave=$_SESSION['pa'];
$nivel=$_SESSION['ni'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Menu Principal</title>
	
	<script type="text/javascript">
		function ir(dato){
			var ventana=document.getElementById("marco");
			if (dato==1){
				ventana.src="GuardarProducto.php";
			}
			if (dato==2){
				ventana.src="ListarProductos.php";
			}
			if (dato==3){
				alert("opcion3");
			}

		}
	</script>
</head>
<body>
<table width="80%" align="center" border="1" cellpadding="10" cellspacing="0">
	<tr>
		<td>
			<table width="100%">
				<tr>
					<td><input type="button" value="Registrar Producto" name="btn1" onclick="ir(1);" /></td>
					<td><input type="button" value="Consulta Por Fechas" name="btn2" onclick="ir(2);"/></td>
					<td width="80%" style="text-align: right;">
						Bienvenido Usuario [ <?php echo $usuario; ?> ] 
						<input type="button" value="Cerrar Sesi&oacute;n" name="btn3" onclick="ir(3);"/>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td>
			<iframe src="" id="marco" frameborder="0" height="450" width="90%"></iframe>
		</td>				
	</tr>
</table>
</body>
</html>