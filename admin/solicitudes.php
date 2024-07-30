<?php
//Cambia el titulo de la pagina
$titulo = 'Solicitudes';
//Verifica que si hayas iniciado sesion
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: ../auth/login.php');
}
?>
<div class="dashboard">
    <?php
    include '../includes/sidebar.php';
    ?>
    <?php
    require '../includes/database.php';
    $db = conectarDB();

    //Arreglo con mensajes de errores
    $errores = [];
    $tipo = '';
    $descripcion = '';
    $lugar = '';
    $nombre = '';
    $fecha = date("Y-m-d H:i:s");
    $idUsuario = $_SESSION['idUsuario'];
    $nombreUsuario = $_SESSION['nombre'];

    //Ejecutar el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Seguridad para los inputs
        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
        $tipo = mysqli_real_escape_string($db, $_POST['tipo']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $lugar = mysqli_real_escape_string($db, $_POST['lugar']);

        if (!$tipo) {
            $errores[] = "Seleccione el tipo de solicitud";
        }

        if (!$descripcion) {
            $errores[] = "La descripción es obligatoria";
        }

        if (!$lugar) {
            $errores[] = "Ingrese el lugar del equipo";
        }


        if (empty($errores)) {

            if (isset($_POST['idEditar'])) {
                $idSolicitud = $_POST['idEditar'];
                // Actualizar solicitud
                $query = "UPDATE solicitudes SET tipo = '$tipo', descripcion = '$descripcion', lugar = '$lugar' WHERE idSolicitud = $idSolicitud;";
                $resultado = mysqli_query($db, $query);
                if ($resultado) {
                    echo "<script>
                            function alerta() {
                                Swal.fire({
                                    title: 'Actualizada!',
                                    text: 'La solicitud se actualizó correctamente.',
                                    icon: 'success'
                                });
                            }
                            document.addEventListener('DOMContentLoaded', (event) => {
                                alerta();
                            });
                        </script>";
                }
            } else {
                // Crear nueva solicitud

                $query = "INSERT INTO solicitudes (tipo, descripcion, lugar, fecha, estado, idUsuarios) VALUES ('$tipo', '$descripcion', '$lugar','$fecha','En proceso', 81);";

                $resultado = mysqli_query($db, $query);
                echo "qewe";
                if ($resultado) {
                    echo "<script>
                            function alerta() {
                                Swal.fire({
                                    title: 'Guardada!',
                                    text: 'La solicitud se generó correctamente.',
                                    icon: 'success'
                                });
                            }
                            document.addEventListener('DOMContentLoaded', (event) => {
                                alerta();
                            });
                        </script>";
                }
            }
        }

        if (isset($_POST['id'])) {
            $idSolicitud = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if ($idSolicitud) {
                $query = "DELETE FROM solicitudes WHERE idSolicitud = $idSolicitud;";
                $resultado = mysqli_query($db, $query);
                if ($resultado) {
                    echo "<script>
                            function alerta() {
                                Swal.fire({
                                    title: 'Eliminada!',
                                    text: 'La solicitud se eliminó correctamente.',
                                    icon: 'success'
                                });
                            }
                            document.addEventListener('DOMContentLoaded', (event) => {
                                alerta();
                            });
                        </script>";
                }
            }
        }
    }
    if (isset($_POST['accion'])) {
        $idSolicituddd = filter_var($_POST['accion'], FILTER_VALIDATE_INT);
        if ($idSolicituddd) {
            $query2 = "UPDATE solicitudes SET estado = 'Realizado' WHERE idSolicitud = $idSolicituddd;";
            $resultado2 = mysqli_query($db, $query2);
            if ($resultado2) {
                echo "<script>
                                function alerta() {
                                    Swal.fire({
                                        title: 'Confirmada!',
                                        text: 'La solicitud se eliminó correctamente.',
                                        icon: 'success'
                                    });
                                }
                                document.addEventListener('DOMContentLoaded', (event) => {
                                    alerta();
                                });
                            </script>";
            }
        }
    }
    ?>


    <div class="contenido">
        <?php include '../includes/header-barra.php'; ?>
        <div class="header">
            <h1 class="titulo-prin">Solicitudes de Mantenimiento Correctivo y Preventivo</h1>

            <!--<button id="solicitud" class="boton boton-solicitud"><span>+</span> Generar Solicitud</button> -->

            <div class="filtros">
                <div class="mostrar">
                    <h1>Filtros:</h1>
                    <div class="contenedor-filtros">
                        <button class="radio"><input id="correctivo" class="rad" type="radio" name="filtro" value="Correctivo" <?php echo ($filtro == 'Correctivo') ? 'checked' : ''; ?>>Correctivo</button>
                        <button class="radio"><input id="preventivo" class="rad" type="radio" name="filtro" value="Preventivo" <?php echo ($filtro == 'Preventivo') ? 'checked' : ''; ?>>Preventivo</button>
                    </div>
                </div>
                <div class="mostrar filtro-mostrar">
                    <h1>Mostrar:</h1>
                    <div class="contenedor-filtros">
                        <button class="radio"><input class="rad" type="radio" name="filtro" value="todos" <?php echo ($filtro == 'Todos') ? 'checked' : ''; ?>>Todas</button>
                        <button class="radio"><input class="rad" type="radio" name="filtro" value="mostrar10" checked>10 solicitudes</button>
                    </div>
                </div>
            </div>

            <input id="buscar" class="input buscar" type="text" placeholder="Buscar solicitudes">
            <?php


            $pagina = isset($_GET['nume']) && is_numeric($_GET['nume']) ? (int)$_GET['nume'] : 1;
            if ($pagina < 1) {
                $pagina = 1;
            }

            // Obtener el número total de solicitudes
            $query = 'SELECT COUNT(*) as total FROM solicitudes;';
            $resultado = mysqli_query($db, $query);
            $totalSolicitudes = mysqli_fetch_assoc($resultado)['total'];
            $_SESSION['totalSolicitudes'] = $totalSolicitudes;
            // Calcular el número total de páginas
            $solicitudesPorPagina = 8;
            $paginas = ceil($totalSolicitudes / $solicitudesPorPagina);

            // Calcular el inicio de la consulta
            $inicio = ($pagina - 1) * $solicitudesPorPagina;

            // Obtener las solicitudes para la página actual
            $query2 = "SELECT solicitudes.*, usuarios.nombre AS nombre
            FROM solicitudes
            JOIN usuarios ON solicitudes.idUsuarios = usuarios.idUsuarios;";
            $resultado2 = mysqli_query($db, $query2);

            $query3 = "SELECT solicitudes.*, usuarios.nombre AS nombre
            FROM solicitudes
            JOIN usuarios ON solicitudes.idUsuarios = usuarios.idUsuarios;";
            $resultado3 = mysqli_query($db, $query3);

            $query = "SELECT solicitudes.*, usuarios.nombre AS nombre
            FROM solicitudes
            JOIN usuarios ON solicitudes.idUsuarios = usuarios.idUsuarios
            LIMIT $inicio,$solicitudesPorPagina;";

            $busqueda = mysqli_query($db, $query);
            ?>


            <!-- Card para dispositivos moviles -->
            <div id="tabla-cel" class="tabla-cel">
                <h1 class="centrar-texto">Solicitudes</h1>


                <?php while ($solicitud = mysqli_fetch_assoc($resultado2)) : ?>
                    <div class="card-movil">
                        <div class="labels">
                            <label>ID solicitud</label>
                            <label>Tipo</label>
                            <label>Lugar</label>
                            <label>Estado</label>
                        </div>
                        <div class="datos">
                            <span class="buscar-card"><?php echo $solicitud['idSolicitud']; ?></span>
                            <span class="buscar-card"><?php echo $solicitud['tipo']; ?></span>
                            <span class="buscar-card"><?php echo $solicitud['lugar']; ?></span>
                            <span class="buscar-card">
                                <button class="boton-estado estado <?php
                                                                    if ($solicitud['estado'] == 'En proceso') {
                                                                        echo 'En-espera';
                                                                    } else if ($solicitud['estado'] == 'Realizado') {
                                                                        echo 'realizado';
                                                                    }
                                                                    ?>" value="<?php echo htmlspecialchars($solicitud['idSolicitud']) ?>">
                                    <?php echo $solicitud['estado']; ?>
                                </button>
                            </span>
                        </div>
                        <div class="acciones-labels">
                            <label>Acciones</label>
                        </div>
                        <div class="acciones acciones-labels">
                            <button class="acciones-boton editar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar']); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0b57d0">
                                    <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                </svg>
                            </button>
                            <button class="acciones-boton mostrar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha'] . ',' . $solicitud['nombre']); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#27AE60">
                                    <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>
                            </button>
                            <button class="acciones-boton eliminar" value="<?php echo $solicitud['idSolicitud']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                                    <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                </svg>
                            </button>
                            <a href="../solicitudPDF.php?idSolicitud=<?php echo $solicitud['idSolicitud']; ?>" target="_blank">
                                <button class="acciones-boton pdf" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#BB271A">
                                        <path d="m720-120 160-160-56-56-64 64v-167h-80v167l-64-64-56 56 160 160ZM560 0v-80h320V0H560ZM240-160q-33 0-56.5-23.5T160-240v-560q0-33 23.5-56.5T240-880h280l240 240v121h-80v-81H480v-200H240v560h240v80H240Zm0-80v-560 560Z" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>


            <!-- Tabla para monitores -->
            <table id="tabla-monitor" class="tabla tabla-monitor">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo</th>
                        <th>Lugar</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php while ($solicitud = mysqli_fetch_assoc($busqueda)) : ?>
                        <tr class="animar-tabla">
                            <td><?php echo $solicitud['idSolicitud']; ?></td>
                            <td><?php echo $solicitud['tipo']; ?></td>
                            <td><?php echo $solicitud['lugar']; ?></td>
                            <td><button class="boton-estado estado <?php
                                                                    if ($solicitud['estado'] == 'En proceso') {
                                                                        echo 'En-espera';
                                                                    } else if ($solicitud['estado'] == 'Realizado') {
                                                                        echo 'realizado';
                                                                    }
                                                                    ?>" value="<?php echo htmlspecialchars($solicitud['idSolicitud']) ?>">
                                    <?php echo $solicitud['estado']; ?></button></td>

                            <td class="acciones">
                                </button>
                                <button class="acciones-boton editar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0b57d0">
                                        <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                    </svg></button>
                                <button class="acciones-boton mostrar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha'] . ',' . $solicitud['nombre']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#27AE60">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </button>
                                <button class="acciones-boton eliminar" value="<?php echo $solicitud['idSolicitud']; ?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                    </svg></button>
                                <a href="../solicitudPDF.php?idSolicitud=<?php echo $solicitud['idSolicitud']; ?>" target="_blank">
                                    <button class="acciones-boton pdf" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha']); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#BB271A">
                                            <path d="m720-120 160-160-56-56-64 64v-167h-80v167l-64-64-56 56 160 160ZM560 0v-80h320V0H560ZM240-160q-33 0-56.5-23.5T160-240v-560q0-33 23.5-56.5T240-880h280l240 240v121h-80v-81H480v-200H240v560h240v80H240Zm0-80v-560 560Z" />
                                        </svg>
                                    </button>
                                </a>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>
            </table>

            <table id="tabla-oculta" class="tabla tabla-oculta">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo</th>
                        <th>Lugar</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>

                    <?php while ($solicitud = mysqli_fetch_assoc($resultado3)) : ?>
                        <tr class="animar-tabla">
                            <td><?php echo $solicitud['idSolicitud']; ?></td>
                            <td><?php echo $solicitud['tipo']; ?></td>
                            <td><?php echo $solicitud['lugar']; ?></td>
                            <td><button class="boton-estado estado <?php
                                                                    if ($solicitud['estado'] == 'En proceso') {
                                                                        echo 'En-espera';
                                                                    } else if ($solicitud['estado'] == 'Realizado') {
                                                                        echo 'realizado';
                                                                    }
                                                                    ?>" value="<?php echo htmlspecialchars($solicitud['idSolicitud']) ?>">
                                    <?php echo $solicitud['estado']; ?></button></td>


                            <td class="acciones">
                                <button class="acciones-boton editar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0b57d0">
                                        <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                    </svg></button>
                                <button class="acciones-boton mostrar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha'] . ',' . $solicitud['nombre']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#27AE60">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </button>
                                <button class="acciones-boton eliminar" value="<?php echo $solicitud['idSolicitud']; ?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EA3323">
                                        <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                    </svg></button>
                                <a href="../solicitudPDF.php?idSolicitud=<?php echo $solicitud['idSolicitud']; ?>" target="_blank">
                                    <button class="acciones-boton pdf" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha']); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#BB271A">
                                            <path d="m720-120 160-160-56-56-64 64v-167h-80v167l-64-64-56 56 160 160ZM560 0v-80h320V0H560ZM240-160q-33 0-56.5-23.5T160-240v-560q0-33 23.5-56.5T240-880h280l240 240v121h-80v-81H480v-200H240v560h240v80H240Zm0-80v-560 560Z" />
                                        </svg>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>


            <div id="pag" class="paginas">
                <div>
                    <label>Pagina <?php echo $pagina . ' de ' . $paginas ?></label>
                </div>

                <div class="paginacion">
                    <?php
                    if ($paginas > 1) {
                        // Botón para ir a la primera página
                        if ($pagina > 1) {
                            echo "<button class='boton-paginacion'><a href='solicitudes.php?nume=1'><svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#5f6368'><path d='M240-240v-480h80v480h-80Zm440 0L440-480l240-240 56 56-184 184 184 184-56 56Z'/></svg></a></button>";
                        }

                        // Botón para ir a la página anterior
                        if ($pagina > 1) {
                            $ant = $pagina - 1;
                            echo "<button class='boton-paginacion'><a href='solicitudes.php?nume=$ant'><svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#5f6368'><path d='M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z'/></svg></a></button>";
                        }

                        // Mostrar la página actual
                        echo "<button class='boton-paginacion actual'>$pagina</button>";

                        // Botón para ir a la página siguiente
                        if ($pagina < $paginas) {
                            $sigui = $pagina + 1;
                            echo "<button class='boton-paginacion'><a href='solicitudes.php?nume=$sigui'><svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px'fill='#5f6368'><path d='M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z'/></svg></a></button>";
                        }

                        // Botón para ir a la última página
                        if ($pagina < $paginas) {
                            echo "<button class='boton-paginacion'><a href='solicitudes.php?nume=$paginas'><svg xmlns='http://www.w3.org/2000/svg' height='24px'viewBox='0 -960 960 960' width='24px'fill='#5f6368'><path d='m280-240-56-56 184-184-184-184 56-56 240 240-240 240Zm360 0v-480h80v480h-80Z'/></svg></a></button>";
                        }
                    }
                    ?>
                </div>
            </div>
            <script src="/js/solicitud.js"></script>
            <script src="/js/eliminar.js"></script>
            <script src="/js/buscar.js"></script>
            <script src="/js/filtrar.js"></script>
            <script src="/js/mostrar.js"></script>
            <script src="/js/editar.js"></script>
            <script src="/js/estado.js"></script>
            <script src="/js/resolucion.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>