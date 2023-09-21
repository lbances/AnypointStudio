<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Listado de Productos</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		.container {
			margin-top: 50px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<h3 class="text-center">Listado de Piezas</h3>
					</div>
					<div class="card-body">
						<form name="frmlistarproductos" method="post" action="listarPiezas.php">
							<div class="form-group">
								<label for="txtdesde">Desde:</label>
								<input type="date" class="form-control" name="txtdesde" required autocomplete="off" />
							</div>
							<div class="form-group">
								<label for="txthasta">Hasta:</label>
								<input type="date" class="form-control" name="txthasta" required autocomplete="off" />
							</div>
							<div class="text-center">
								<input type="submit" class="btn btn-primary" name="btnlistar" value="Buscar" />
							</div>
						</form>
						<?php
						if(isset($_POST["btnlistar"])){
							$desde = $_POST["txtdesde"];
							$hasta = $_POST["txthasta"];
							$contenido = file_get_contents("http://localhost:8090/filtrarFechas?desde=".$desde."&hasta=".$hasta);
							$reg = json_decode($contenido, true);
						?>
						<div class="mt-4">
							<fieldset>
								<legend>Listado de Productos:</legend>
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Código de pieza</th>
												<th>Fecha de registro</th>
												<th>Linea de pieza</th>
												<th>Fabrica</th>
												<th>Usuario</th>
												<th>Cantidad de piezas</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($reg as $valor) {
													echo("<tr>");
													echo("<td>".$valor['codpie']."</td>");
													echo("<td>".$valor['fecpie']."</td>");
													echo("<td>".$valor['linpie']."</td>");
													echo("<td>".$valor['nomfab']."</td>");
													echo("<td>".$valor['nomusu']."</td>");
													echo("<td>".$valor['canpie']."</td>");
													echo("</tr>");
												}
											?>
										</tbody>
									</table>
								</div>
							</fieldset>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>