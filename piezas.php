<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pieza</title>
    <!-- Enlaces Bootstrap CSS y JavaScript -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h1 class="text-center">Registrar Pieza</h1>
        <!-- Conmienza formulario de registro de usuario -->
        <form name="frmregistrarpieza" method="post" action="">
            <!-- Campos de entrada y botón para registrar -->
            <table class="table">

                <tr>
                    <td>Código de pieza:</td>
                    <td><input type="number" class="form-control" name="txtCodigo" maxlength="10" required
                            autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td>Fecha de registro:</td>
                    <td><input type="date" class="form-control" name="txtFecha" maxlength="20" required
                            autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td>Linea de piezas:</td>
                    <td><input type="text" class="form-control" name="txtLinea" maxlength="10" required
                            autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td>Código de fabrica:</td>
                    <td><input type="number" class="form-control" name="txtCodFabrica" maxlength="10" required
                            autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td>Código de usuario:</td>
                    <td><input type="number" class="form-control" name="txtCodUsuario" maxlength="10" required
                            autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td>Cantidad de piezas:</td>
                    <td><input type="number" class="form-control" name="txtCantidad" maxlength="10" required
                            autocomplete="off" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <center><input type="submit" class="btn btn-primary" name="btnguardar" value="Guardar Pieza" />
                        </center>
                    </td>
                </tr>
            </table>
        </form>
        <!-- Termina formulario de registro de usuario -->

        <!--Comienza funcionalidad de Guardar pieza-->
        <?php
        if (isset($_POST["btnguardar"])) {
            $codpie = (int) $_POST["txtCodigo"];
            $fecpie = $_POST["txtFecha"];
            $linpie = $_POST["txtLinea"];
            $codfab = (int) $_POST["txtCodFabrica"];
            $codusu = (int) $_POST["txtCodUsuario"];
            $canpie = (int) $_POST["txtCantidad"];

            $url = "http://localhost:8090/createPiezas";
            $datos = array(
                "codpie" => $codpie,
                "fecpie" => $fecpie,
                "linpie" => $linpie,
                "codfab" => $codfab,
                "codusu" => $codusu,
                "canpie" => $canpie
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
                echo "<center>Error al registrar pieza</center>";
            } else {
                echo "<center>El registro se realizó correctamente</center>";

            }
        }
        ?>
        <!--Termina funcionalidad de Guardar pieza-->

        <!-- Botones para mostrar los bloques de consulta, eliminación y búsqueda/edición -->
        <div class="text-center mt-2">

            <button class="btn btn-primary" onclick="mostrarConsultarUsuarios()">Listar Piezas</button>

            <button class="btn btn-danger" onclick="mostrarEliminarUsuario()">Eliminar Pieza</button>

            <button class="btn btn-info" onclick="mostrarBuscarEditarUsuario()">Buscar y Editar Pieza</button>

            <a href="listarPiezas.php" class="btn btn-secondary">Listar piezas</a>
        </div>
        <!-- Botones para mostrar los bloques de consulta, eliminación y búsqueda/edición -->

        <!-- Comienza tabla que muestra todos los registros de la tabla Piezas -->
        <div id="consultarPiezas" style="display: none;">
            <h1 class="text-center mt-4">Consultar Pieza</h1>
            <!-- Contenido para consultar usuarios -->
            <div class="mt-4">
                <fieldset>
                    <legend class="text-center">Listado de Piezas:</legend>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Código de Pieza</th>
                                    <th scope="col">Fecha de registro</th>
                                    <th scope="col">Línea de Pieza</th>
                                    <th scope="col">Fábrica</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Cantidad de Piezas</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                $sql = "SELECT p.codpie,
                                               p.fecpie,
                                               p.linpie,
                                               f.nomfab,
                                               u.nomusu,
                                               p.canpie
                                        FROM
                                            piezas p
                                        JOIN
                                            fabrica f ON p.codfab = f.codfab
                                        JOIN
                                            usuario u ON p.codusu = u.codusu;";

                                $result = $conn->query($sql);

                                // Bucle para imprimir todos los registros
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["codpie"] . "</td>";
                                        echo "<td>" . $row["fecpie"] . "</td>";
                                        echo "<td>" . $row["linpie"] . "</td>";
                                        echo "<td>" . $row["nomfab"] . "</td>";
                                        echo "<td>" . $row["nomusu"] . "</td>";
                                        echo "<td>" . $row["canpie"] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center'>No se encontraron resultados.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
        <!-- Termina tabla que muestra todos los registros de la tabla Piezas -->

        <!-- Comienza eliminar registros de la tabla piezas -->
        <div id="eliminarPieza" style="display: none;">
            <h1 class="text-center mt-4">Eliminar Pieza</h1>

            <!-- Contenido para eliminar usuarios -->
            <form name="frmeliminarpieza" method="post" action="">
                <label for="txtcodigoeliminar">Código de Pieza a Eliminar:</label>
                <input type="number" class="form-control" name="txtcodigoeliminar" maxlength="10" required
                    autocomplete="off" />
                <div class="text-center mt-3">
                    <input type="submit" class="btn btn-danger" name="btneliminar" value="Eliminar Pieza" />
                </div>
            </form>

            <!-- Comienza funcionalidad para eliminar piezas por código -->
            <?php
            if (isset($_POST["btneliminar"])) {
                $codusu_eliminar = (int) $_POST["txtcodigoeliminar"];

                $url_eliminar = "http://localhost:8090/deletePiezas/" . $codusu_eliminar;
                $datos_eliminar = array(
                    "codpie" => $codusu_eliminar
                );
                $datos_json_eliminar = json_encode($datos_eliminar);

                // Configura la solicitud POST para eliminar pieza
                $curl_eliminar = curl_init($url_eliminar);
                curl_setopt($curl_eliminar, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($curl_eliminar, CURLOPT_POSTFIELDS, $datos_json_eliminar);
                curl_setopt($curl_eliminar, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($curl_eliminar, CURLOPT_RETURNTRANSFER, true);

                // Ejecuta la solicitud POST para eliminar pieza
                $respuesta_eliminar = curl_exec($curl_eliminar);

                // Cierra la solicitud
                curl_close($curl_eliminar);

                $respuesta_decodificada_eliminar = json_decode($respuesta_eliminar);

                if (empty($respuesta_decodificada_eliminar)) {
                    echo "<center>Error al eliminar pieza</center>";
                } else {
                    echo "<center>El registro fue eliminado correctamente</center>";
                    echo '<meta http-equiv="refresh" content="0">';
                }
            }
            ?>
            <!-- Termina funcionalidad para eliminar piezas por código -->

        </div>
        <!-- Termina eliminar registros de la tabla piezas -->

        <!-- Comienza actualizar registros de la tabla piezas -->
        <div id="buscarEditarPieza" style="display: none;">
            <h1 class="text-center mt-4">Buscar y Editar Pieza</h1>

            <!-- Contenido del formulario para buscar el registro de la pieza por código -->
            <form name="frmbuscarpieza" method="post" action="">
                <div class="form-group">
                    <label for="txtcodigobuscar">Código de Pieza a Buscar:</label>
                    <input type="number" class="form-control" name="txtcodigobuscar" maxlength="10" required
                        autocomplete="off" />
                </div>
                <div class="text-center">
                    <input type="submit" class="btn btn-info" name="btnbuscar" value="Buscar Pieza" />
                </div>
            </form>
            <!-- Contenido del formulario para buscar el registro de la pieza por código -->

            <!-- Contenedor que busca el registro de la pieza y los muestra mediante echo -->
            <div id="resultadoBusqueda" class="mb-4">
                <!-- Comienza la funcionalidad de busqueda -->
                <?php
                if (isset($_POST["btnbuscar"])) {
                    $codusu_buscar = (int) $_POST["txtcodigobuscar"];

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

                    // Consulta SQL para obtener el registro de la pieza
                    $sql_buscar = "SELECT * FROM piezas WHERE codpie = $codusu_buscar";

                    $result_buscar = $conn->query($sql_buscar);

                    if ($result_buscar->num_rows > 0) {
                        $pieza_encontrado = $result_buscar->fetch_assoc();

                        // Mostrar el formulario con los datos de la pieza
                        echo '<h2 class="text-center mt-4">Editar Pieza</h2>';
                        echo '<form name="frmeditarpieza" method="post" action="">';
                        echo '<input type="hidden" name="txtCodPieza" value="' . $pieza_encontrado["codpie"] . '" />';

                        echo '<div class="form-group">';
                        echo '<label for="txtFechaPieza">Fecha de registro:</label>';
                        echo '<input type="date" class="form-control" name="txtFechaPieza" value="' . $pieza_encontrado["fecpie"] . '" />';
                        echo '</div>';

                        echo '<div class="form-group">';
                        echo '<label for="txtLinea">Linea de Pieza:</label>';
                        echo '<input type="text" class="form-control" name="txtLinea" value="' . $pieza_encontrado["linpie"] . '" />';
                        echo '</div>';

                        echo '<div class="form-group">';
                        echo '<label for="txtCodigoFab">Código de Fábrica:</label>';
                        echo '<input type="number" class="form-control" name="txtCodigoFab" value="' . $pieza_encontrado["codfab"] . '" />';
                        echo '</div>';

                        echo '<div class="form-group">';
                        echo '<label for="txtCodigoUsu">Código de Usuario:</label>';
                        echo '<input type="number" class="form-control" name="txtCodigoUsu" value="' . $pieza_encontrado["codusu"] . '" />';
                        echo '</div>';

                        echo '<div class="form-group">';
                        echo '<label for="txtCantidad">Cantidad de piezas:</label>';
                        echo '<input type="number" class="form-control" name="txtCantidad" value="' . $pieza_encontrado["canpie"] . '" />';
                        echo '</div>';

                        echo '<div class="text-center">';
                        echo '<input type="submit" class="btn btn-success" name="btnmodificar" value="Modificar pieza" />';
                        echo '</div>';
                        echo '</form>';
                        // Mostrar el formulario con los datos de la pieza
                
                    } else {
                        echo "<p class='text-center'>No se encontró la pieza con ese código.</p>";
                    }

                    // Cierra la conexión
                    $conn->close();
                }
                // Termina la funcionalidad de busqueda
                
                // Comienza la funcionalidad de modificar datos de la pieza
                if (isset($_POST["btnmodificar"])) {
                    $codpie = (int) $_POST["txtCodPieza"];
                    $fecpie = $_POST["txtFechaPieza"];
                    $linpie = $_POST["txtLinea"];
                    $codfab = (int) $_POST["txtCodigoFab"];
                    $codusu = (int) $_POST["txtCodigoUsu"];
                    $canpie = (int) $_POST["txtCantidad"];

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

                    // Actualizar los datos de la pieza
                    $sql_modificar = "UPDATE piezas SET fecpie='$fecpie', linpie='$linpie', codfab='$codfab', codusu='$codusu', canpie='$canpie' WHERE codpie='$codpie'";

                    if ($conn->query($sql_modificar) === TRUE) {
                        echo "<p class='text-center'>Los datos de la pieza se han modificado con éxito.</p>";
                    } else {
                        echo "<p class='text-center'>Ocurrió un error al modificar los datos de la pieza : " . $conn->error . "</p>";
                    }

                    // Cierra la conexión
                    $conn->close();

                    // Comienza la funcionalidad de modificar datos de la pieza
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Termina la funcionalidad de modificar los datos de la pieza -->

    <!-- Funcionalidad de los botones -->
    <script>
        function mostrarConsultarUsuarios() {
            document.getElementById("consultarPiezas").style.display = "block";
            document.getElementById("eliminarPieza").style.display = "none";
            document.getElementById("buscarEditarPieza").style.display = "none";
        }

        function mostrarEliminarUsuario() {
            document.getElementById("consultarPiezas").style.display = "none";
            document.getElementById("eliminarPieza").style.display = "block";
            document.getElementById("buscarEditarPieza").style.display = "none";
        }

        function mostrarBuscarEditarUsuario() {
            document.getElementById("consultarPiezas").style.display = "none";
            document.getElementById("eliminarPieza").style.display = "none";
            document.getElementById("buscarEditarPieza").style.display = "block";
        }
    </script>
    <!-- Funcionalidad de los botones -->

</body>

</html>