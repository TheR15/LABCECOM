<?php

use Classes\Email;

require '../classes/Email.php';
$titulo = 'Solicitudes';
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

    // Arreglo con mensajes de errores
    $errores = [];

    $tipo = '';
    $descripcion = '';
    $lugar = '';
    $estado = 'En espera';
    $fecha = date("Y-m-d H:i:s");
    $idUsuario = $_SESSION['idUsuario'];
    $nombreUsuario = $_SESSION['nombre'];

    setlocale(LC_TIME, 'es_Mx.UTF-8');
    $fechaFormateada = strftime('%A, %e de %B del %Y');

    //Ejecutar el codigo despues de que el usuario envia el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Seguridad para los inputs
        $tipo = mysqli_real_escape_string($db, $_POST['tipo']);
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
        $lugar = mysqli_real_escape_string($db, $_POST['lugar']);

        $query = "INSERT INTO solicitudes (tipo,descripcion,lugar,fecha,estado,idUsuarios) VALUES
        ('$tipo','$descripcion','$lugar','$fecha','$estado',$idUsuario)";
        $resultado = mysqli_query($db, $query);


        if ($resultado) {
            $mail = new Email(null, $nombre, null);
            $mail->notificarEmail();
            header('Location: ../usuario/solicitudes.php');
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
    ?>

    <div class="contenido">
        <?php include '../includes/header-barra.php'; ?>
        <div class="header">
            
            <button id="solicitud" class="boton boton-solicitud"><span>+</span> Generar Solicitud</button>
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

            // Calcular el número total de páginas
            $solicitudesPorPagina = 10;
            $paginas = ceil($totalSolicitudes / $solicitudesPorPagina);

            // Calcular el inicio de la consulta
            $inicio = ($pagina - 1) * $solicitudesPorPagina;



            // Obtener las solicitudes para la página actual
            $query2 = "SELECT solicitudes.*, usuarios.nombre AS nombre
            FROM solicitudes
            JOIN usuarios ON solicitudes.idUsuarios = usuarios.idUsuarios
            WHERE solicitudes.idUsuarios = $idUsuario;
            ";
            $resultado2 = mysqli_query($db, $query2);

            $query3 = "SELECT solicitudes.*, usuarios.nombre AS nombre
            FROM solicitudes
            JOIN usuarios ON solicitudes.idUsuarios = usuarios.idUsuarios
            WHERE solicitudes.idUsuarios = $idUsuario;
            ";
            $resultado3 = mysqli_query($db, $query3);

            $query = "SELECT solicitudes.*, usuarios.nombre AS nombre
            FROM solicitudes
            JOIN usuarios ON solicitudes.idUsuarios = usuarios.idUsuarios
            WHERE solicitudes.idUsuarios = $idUsuario";
            $busqueda = mysqli_query($db, $query);
            ?>

            <h2 class="centrar-texto">Mis solicitudes</h2>
            <!-- Card para dispositivos moviles -->
            <div id="tabla-cel" class="tabla-cel">
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
                            <button class="acciones-boton mostrar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha'] . ',' . $solicitud['nombre']); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#27AE60">
                                    <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                </svg>
                            </button>
                            <a href="../solicitudPDF.php?idSolicitud=<?php echo $solicitud['idSolicitud']; ?>" target="_blank">
                                <button class="acciones-boton pdf" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha'] . ',' . $solicitud['fecha']); ?>">
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
                                <button class="acciones-boton mostrar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha'] . ',' . $solicitud['nombre']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#27AE60">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </button>
                                <a href="../solicitudPDF.php?idSolicitud=<?php echo $solicitud['idSolicitud']; ?>&nombre=<?php echo $nombre ?>" target="_blank">
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
                                <button class="acciones-boton mostrar" value="<?php echo htmlspecialchars($solicitud['idSolicitud'] . ',' . $solicitud['tipo'] . ',' . $solicitud['descripcion'] . ',' . $solicitud['lugar'] . ',' . $solicitud['fecha'] . ',' . $solicitud['nombre']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#27AE60">
                                        <path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                    </svg>
                                </button>
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
                </div>
            </div>


            <script src="/js/resolucion.js"></script>
            <script src="/js/solicitudUsuario.js"></script>
            <script src="/js/buscar.js"></script>
            <script src="/js/mostrar.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>