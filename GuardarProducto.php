<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registrar Producto</title>
</head>
<body>
<form name="frmregistrarproducto" method="post" action="GuardarProducto.php">
	<table align="center">
		<tr>
			<td>Descripci&oacute;n del Producto:</td>
			<td><input type="text" name="txtdes" maxlength="60" size="35"
				required autocomplete="off"/></td>
		</tr>
		<tr>
			<td>Categoria:</td>
			<td><input type="text" name="txtcat" maxlength="10" size="10"
				required autocomplete="off"/></td>
		</tr>
		<tr>
			<td>Unidad:</td>
			<td><input type="text" name="txtuni" maxlength="30" size="20"
				required autocomplete="off"/></td>
		</tr>
		<tr>
			<td>Precio de Compra:</td>
			<td><input type="number" name="txtpco" maxlength="10" size="10"
				required autocomplete="off" value="0.00" inputmode="decimal"
				style="text-align: right;"/></td>
		</tr>
		<tr>
			<td>Precio de Venta:</td>
			<td><input type="number" name="txtpve" maxlength="10" size="10"
				required autocomplete="off" value="0.00" inputmode="decimal"
				style="text-align: right;"/></td>
		</tr>
		<tr>
			<td>Stock:</td>
			<td><input type="number" name="txtsto" maxlength="10" size="10"
				required autocomplete="off" value="0.00" inputmode="decimal"
				style="text-align: right;"/></td>
		</tr>
		<tr>
			<td>Fecha de Registro:</td>
			<td><input type="date" name="txtfre" maxlength="10" size="10"
				required autocomplete="off" /></td>
		</tr>
		<tr>
			<td colspan="2"><center><input type="submit" name="btnguardar" value="Guardar Producto" /></center></td>
		</tr>
	</table>	
</form>
</body>
</html>
<?php
function enviardatos($url,$datos){
	$curl=curl_init();
	$tiempo=300;
	curl_setopt($curl,CURLOPT_HTTPHEADER,array(
		'Content-Type: application/json'
	));
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_POST,true);
	curl_setopt($curl,CURLOPT_POSTFIELDS,$datos);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,$tiempo);
	$resp=curl_exec($curl);
	curl_close($curl);
	return $resp;
}

if(isset($_POST["btnguardar"])){
	//--- LEER CAJAS DE TEXTO ---
	$codigo=0;
	$despro=$_POST["txtdes"];
	$codcat=intval($_POST["txtcat"]);
	$unipro=$_POST["txtuni"];
	$pcopro=floatval($_POST["txtpco"]);
	$pvepro=floatval($_POST["txtpve"]);
	$stopro=floatval($_POST["txtsto"]);
	$frepro=$_POST["txtfre"];

	$url="http://localhost:8090/Producto";
	$datos=[
		"codpro"=> $codigo,
		"codcat"=> $codcat,
		"despro"=> $despro,
		"unipro"=> $unipro,
		"pcopro"=> $pcopro,
		"pvepro"=> $pvepro,
		"stopro"=> $stopro,
		"frepro"=> $frepro
	];
	$datos=json_encode($datos);
	$respuesta=enviardatos($url,$datos);
	$respuesta=json_decode($respuesta,$datos);
	if($respuesta==""){
		echo "<center>Error al guardar el Registro de Producto.....!</center>";
		echo $datos;
	}
	else{
		echo "<center>Registro Correctamente los Datos del Nuevo Producto.....!</center>";
	}
}
?>