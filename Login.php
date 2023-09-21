<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Iniciar Sesión</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		.container {
			margin-top: 300px;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h3 class="text-center">Iniciar Sesión</h3>
					</div>
					<div class="card-body">
						<form name="frmlogin" method="POST" action="">
							<div class="form-group">
								<label for="txtus">Usuario:</label>
								<input type="text" class="form-control" name="txtus" id="txtus" maxlength="10" autocomplete="off" required />
							</div>
							<div class="form-group">
								<label for="txtpa">Contraseña:</label>
								<input type="password" class="form-control" name="txtpa" id="txtpa" maxlength="10" autocomplete="off" required />
							</div>
							<div class="text-center">
								<input type="submit" class="btn btn-primary" name="btnaceptar" value="Ingresar">
								<a href="usuario.php" class="btn btn-secondary">Registrar Usuario</a>                                
							</div>
						</form>
						<?php
						if (isset($_POST['btnaceptar'])){
							$us = $_POST['txtus'];
							$pa = $_POST['txtpa'];
							$contenido = file_get_contents("http://localhost:8090/validarUsuario/".$us."/".$pa);
							$reg = json_decode($contenido, true);

							if (empty($reg)) {
								echo "<script>alert('El usuario no existe.');</script>";
							} else {
								echo "<script>alert('Sesión iniciada correctamente.'); window.location.href = 'piezas.php';</script>";
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>