<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuario</title>
    <!-- Enlaces Bootstrap CSS y JavaScript -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center">Registrar Usuario</h1>
        <!-- Comienza el formulario de registro de usuario -->
        <form name="frmregistrarusuario" method="post" action="">
            <!-- Campos de entrada y botón para registrar -->
            <table class="table">
                <tr>
                    <td>Código:</td>
                    <td><input type="number" class="form-control" name="txtcodigo" maxlength="10" required autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td>Nombre:</td>
                    <td><input type="text" class="form-control" name="txtnombre" maxlength="20" required autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td>Contraseña:</td>
                    <td><input type="password" class="form-control" name="txtcontrasena" maxlength="20" required autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td>Código de Fábrica:</td>
                    <td><input type="number" class="form-control" name="txtcodigofabrica" maxlength="10" required autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <center><input type="submit" class="btn btn-primary" name="btnguardar" value="Guardar Usuario" /></center>
                    </td>
                </tr>
            </table>
        </form>
        <!-- Termina el formulario de registro de usuario -->

        <!-- Comienza funcionalidad para el registro de usuario -->
        <?php
        if (isset($_POST["btnguardar"])) {
            $codusu = (int) $_POST["txtcodigo"];
            $nomusu = $_POST["txtnombre"];
            $clausu = $_POST["txtcontrasena"];
            $codfab = (int) $_POST["txtcodigofabrica"];

            $url = "http://localhost:8090/createUsuario";
            $datos = array(
                "codusu" => $codusu,
                "nomusu" => $nomusu,
                "clausu" => $clausu,
                "codfab" => $codfab
            );
            $datos_json = json_encode($datos);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $datos_json);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $respuesta = curl_exec($curl);

            curl_close($curl);

            $respuesta_decodificada = json_decode($respuesta);

            if (empty($respuesta_decodificada)) {
                echo "<center>Error al guardar el Registro de Usuario...</center>";
            } else {
                echo "<center>Registro Correctamente los Datos del Nuevo Usuario...</center>";
            }
        }
        ?>
        <!-- Termina funcionalidad para el registro de usuario -->

        <!-- Botones para mostrar los bloques de consulta, eliminación y búsqueda/edición -->
        <div class="text-center mt-2">
            <button class="btn btn-primary" onclick="mostrarConsultarUsuarios()">Listar Usuarios</button>

            <button class="btn btn-danger" onclick="mostrarEliminarUsuario()">Eliminar Usuario</button>

            <button class="btn btn-info" onclick="mostrarBuscarEditarUsuario()">Buscar y Editar Usuario</button>

            <a href="login.php" class="btn btn-secondary">Volver al login</a>
        </div>
        <!-- Botones para mostrar los bloques de consulta, eliminación y búsqueda/edición -->

        <!-- Comienza tabla que muestra todos los registros de Usuarios -->
        <div id="consultarUsuarios" style="display: none;">
            <h1 class="text-center mt-4">Consultar Usuarios</h1>
            <!-- Contenido para consultar usuarios -->
            <div class="mt-4">
                <fieldset>
                    <legend class="text-center">Listado de Usuarios:</legend>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Contraseña</th>
                                    <th scope="col">Fábrica</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- Funcionalidad de busqueda -->
                                <?php
                                $servername = "localhost";
                                $username = "root";
                                $password = "lbances";
                                $database = "FabricasEF";

                                // Crea una conexión
                                $conn = new mysqli($servername, $username, $password, $database);

                                // Verifica la conexión
                                if ($conn->connect_error) {
                                    die("Conexión fallida: " . $conn->connect_error);
                                }

                                // Consulta SQL para obtener todos los usuarios
                                $sql = "SELECT
                                            u.codusu,
                                            u.nomusu,
                                            u.clausu,
                                            f.nomfab
                                        FROM
                                            usuario u
                                        JOIN
                                            fabrica f ON u.codfab = f.codfab;";

                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["codusu"] . "</td>";
                                        echo "<td>" . $row["nomusu"] . "</td>";
                                        echo "<td>" . $row["clausu"] . "</td>";
                                        echo "<td>" . $row["nomfab"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No se encontraron resultados.</td></tr>";
                                }
                                ?>
                                <!-- Funcionalidad de busqueda -->

                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
        <!-- Termina tabla que muestra todos los registros de Usuarios -->

        <!-- Comienza la funcionalidad de eliminar usuario -->
        <div id="eliminarUsuario" style="display: none;">
            <h1 class="text-center mt-4">Eliminar Usuario</h1>
            <!-- Contenido para eliminar usuarios -->
            <form name="frmeliminarusuario" method="post" action="">
                <label for="txtcodigoeliminar">Código de Usuario a Eliminar:</label>
                <input type="number" class="form-control" name="txtcodigoeliminar" maxlength="10" required
                    autocomplete="off" />
                <div class="text-center mt-3">
                    <input type="submit" class="btn btn-danger" name="btneliminar" value="Eliminar Usuario" />
                </div>
            </form>
            <!-- Contenido para eliminar usuarios -->

            <?php
            if (isset($_POST["btneliminar"])) {
                $codusu_eliminar = (int) $_POST["txtcodigoeliminar"];
            
                $url_eliminar = "http://localhost:8090/deleteUsuario/" . $codusu_eliminar;
                $datos_eliminar = array(
                    "codusu" => $codusu_eliminar
                );
                $datos_json_eliminar = json_encode($datos_eliminar);

                // Configura la solicitud POST para eliminar el usuario
                $curl_eliminar = curl_init($url_eliminar);
                curl_setopt($curl_eliminar, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($curl_eliminar, CURLOPT_POSTFIELDS, $datos_json_eliminar);
                curl_setopt($curl_eliminar, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl_eliminar, CURLOPT_RETURNTRANSFER, true);

                // Ejecuta la solicitud POST para eliminar el usuario
                $respuesta_eliminar = curl_exec($curl_eliminar);

                // Cierra la solicitud
                curl_close($curl_eliminar);

                $respuesta_decodificada_eliminar = json_decode($respuesta_eliminar);

                if (empty($respuesta_decodificada_eliminar)) {
                    echo "<center>Error al eliminar el Usuario...</center>";
                } else {
                    echo "<center>Usuario eliminado correctamente...</center>";
                    echo '<meta http-equiv="refresh" content="0">';
                }
            }
            ?>
        </div>
        <!-- Comienza la funcionalidad de eliminar usuario -->

        <!-- Comienza la busqueda de usuario por código -->
        <div id="buscarEditarUsuario" style="display: none;">
            <h1 class="text-center mt-4">Buscar y Editar Usuario</h1>

            <!-- Formulario para la busqueda de usuario por código -->
            <form name="frmbuscarusuario" method="post" action="">
                <div class="form-group">
                    <label for="txtcodigobuscar">Código de Usuario a Buscar:</label>
                    <input type="number" class="form-control" name="txtcodigobuscar" maxlength="10" required autocomplete="off" />
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-info" name="btnbuscar" value="Buscar Usuario" />
                </div>
            </form>
            <!-- Formulario para la busqueda de usuario por código -->

            <!-- Contenido que muestra los datos del usuario -->
            <div id="resultadoBusqueda">
                <!-- Comienza la funcionalidad de busqueda -->
                <?php
                if (isset($_POST["btnbuscar"])) {
                    $codusu_buscar = (int) $_POST["txtcodigobuscar"];

                    // Conexión a la base de datos (ajusta las credenciales)
                    $servername = "localhost";
                    $username = "root";
                    $password = "lbances";
                    $database = "FabricasEF";

                    // Crea una conexión
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Verifica la conexión
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Consulta SQL para obtener el usuario con el código dado
                    $sql_buscar = "SELECT * FROM usuario WHERE codusu = $codusu_buscar";

                    $result_buscar = $conn->query($sql_buscar);

                    if ($result_buscar->num_rows > 0) {
                        $usuario_encontrado = $result_buscar->fetch_assoc();

                        // Mostrar el formulario de edición con los datos del usuario
                        echo '<h2 class="text-center mt-4">Editar Usuario</h2>';
                        echo '<form name="frmeditarusuario" method="post" action="">';
                        echo '<input type="hidden" name="txtcodigomodificar" value="' . $usuario_encontrado["codusu"] . '" />';

                        echo '<div class="form-group">';
                        echo '<label for="txtnombremodificar">Nombre:</label>';
                        echo '<input type="text" class="form-control" name="txtnombremodificar" value="' . $usuario_encontrado["nomusu"] . '" />';
                        echo '</div>';

                        echo '<div class="form-group">';
                        echo '<label for="txtContrasena">Contraseña:</label>';
                        echo '<input type="number" class="form-control" name="txtContrasena" value="' . $usuario_encontrado["clausu"] . '" />';
                        echo '</div>';

                        echo '<div class="form-group">';
                        echo '<label for="txtcodigofabricamodificar">Código de Fábrica:</label>';
                        echo '<input type="number" class="form-control" name="txtcodigofabricamodificar" value="' . $usuario_encontrado["codfab"] . '" />';
                        echo '</div>';

                        echo '<div class="text-center">';
                        echo '<input type="submit" class="btn btn-success" name="btnmodificar" value="Modificar Usuario" />';
                        echo '</div>';
                        echo '</form>';
                        // Mostrar el formulario de edición con los datos del usuario

                    } else {
                        echo "<p class='text-center'>No se encontró un usuario con ese código.</p>";
                    }

                    // Cierra la conexión
                    $conn->close();
                }
                // Termina la funcionalidad de busqueda

                // Comienza la funcionalidad de modificación
                if (isset($_POST["btnmodificar"])) {
                    $codusu_modificar = (int) $_POST["txtcodigomodificar"];
                    $nombremod = $_POST["txtnombremodificar"];
                    $contrasena = $_POST["txtContrasena"];
                    $codfabmod = (int) $_POST["txtcodigofabricamodificar"];

                    $servername = "localhost";
                    $username = "root";
                    $password = "lbances";
                    $database = "FabricasEF";

                    // Crea una conexión
                    $conn = new mysqli($servername, $username, $password, $database);

                    // Verifica la conexión
                    if ($conn->connect_error) {
                        die("Conexión fallida: " . $conn->connect_error);
                    }

                    // Actualizar los datos del usuario
                    $sql_modificar = "UPDATE usuario SET nomusu='$nombremod', clausu='$contrasena', codfab='$codfabmod' WHERE codusu='$codusu_modificar'";

                    if ($conn->query($sql_modificar) === TRUE) {
                        echo "<p class='text-center'>Usuario modificado correctamente.</p>";
                    } else {
                        echo "<p class='text-center'>Error al modificar el Usuario: " . $conn->error . "</p>";
                    }

                    // Cierra la conexión
                    $conn->close();
                }
                ?>
                <!-- Termina la funcionalidad de modificación -->
            </div>
        </div>
    </div>

    <!-- Funcionalidad de los botones -->
    <script>
        function mostrarConsultarUsuarios() {
            document.getElementById("consultarUsuarios").style.display = "block";
            document.getElementById("eliminarUsuario").style.display = "none";
            document.getElementById("buscarEditarUsuario").style.display = "none";
        }

        function mostrarEliminarUsuario() {
            document.getElementById("consultarUsuarios").style.display = "none";
            document.getElementById("eliminarUsuario").style.display = "block";
            document.getElementById("buscarEditarUsuario").style.display = "none";
        }

        function mostrarBuscarEditarUsuario() {
            document.getElementById("consultarUsuarios").style.display = "none";
            document.getElementById("eliminarUsuario").style.display = "none";
            document.getElementById("buscarEditarUsuario").style.display = "block";
        }
    </script>
    <!-- Funcionalidad de los botones -->

</body>
</html>