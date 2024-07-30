<?php
//Titulo de la Pagina
$titulo = 'Estadistica';
//Inicio de Sesion con variables de sesion
session_start();
$idUsuario = $_SESSION['idUsuario'];
$nombreUsuario = $_SESSION['nombre'];
$totalSolicitudes = $_SESSION['totalSolicitudes'];
//Comprobamos que si esten retornando las variables de sesion
if (!isset($_SESSION['login'])) {
    header('Location: ../auth/login.php');
}
?>

<div class="dashboard">
    <?php
    include '../includes/sidebar.php';
    require '../includes/database.php';
    $db = conectarDB();
    //Obtener el total de usuarios
    $query = 'SELECT * FROM usuarios;';
    $resultado = mysqli_query($db, $query);
    $totalUsuarios = mysqli_num_rows($resultado);
    ?>
    <div id="contenido" class="contenido">
        <?php include '../includes/header-barra.php'; ?>
        <h1 class="centrar-texto"><?php echo $titulo ?></h1>

        <div class="contenedor-estadisticas">
            <div class="estadistica card-usuarios">
                <div class="estadistica-texto-icono">
                    <div class="icono-totales usuarios">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="35px" viewBox="0 0 24 24" width="35px" fill="#fff">
                            <g>
                                <rect fill="none" height="24" width="24" />
                            </g>
                            <g>
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm0 14c-2.03 0-4.43-.82-6.14-2.88C7.55 15.8 9.68 15 12 15s4.45.8 6.14 2.12C16.43 19.18 14.03 20 12 20z" />
                            </g>
                        </svg>
                    </div>
                </div>

                <div class="estadistica-dato">
                    <p><?php echo $totalUsuarios ?></p>
                    <h3>Total de Usuarios</h3>
                </div>
            </div>


            <div class="estadistica card-solicitudes">
                <div class="estadistica-texto-icono">
                    <div class="icono-totales solicitudes">
                        <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 0 24 24" width="35px" fill="#fff">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z" />
                        </svg>
                    </div>
                </div>
                <div class="estadistica-dato">
                    <p><?php echo $totalSolicitudes ?></p>
                    <h3>Total de Solicitudes</h3>
                </div>
            </div>
            <div class="estadistica card-consultas">
                <div class="estadistica-texto-icono">
                    <div class="icono-totales consultas">
                        <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 0 24 24" width="35px" fill="#fff">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM7 9h10c.55 0 1 .45 1 1s-.45 1-1 1H7c-.55 0-1-.45-1-1s.45-1 1-1zm6 5H7c-.55 0-1-.45-1-1s.45-1 1-1h6c.55 0 1 .45 1 1s-.45 1-1 1zm4-6H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1z" />
                        </svg>
                    </div>
                </div>
                <div class="estadistica-dato">
                    <p><?php echo $totalSolicitudes ?></p>
                    <h3>Total de Consultas</h3>
                </div>
            </div>
            <div class="estadistica card-impresiones">
                <div class="estadistica-texto-icono">
                    <div class="icono-totales impresiones">
                        <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 0 24 24" width="35px" fill="#fff">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M19 8H5c-1.66 0-3 1.34-3 3v4c0 1.1.9 2 2 2h2v2c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2v-2h2c1.1 0 2-.9 2-2v-4c0-1.66-1.34-3-3-3zm-4 11H9c-.55 0-1-.45-1-1v-4h8v4c0 .55-.45 1-1 1zm4-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-2-9H7c-.55 0-1 .45-1 1v2c0 .55.45 1 1 1h10c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1z" />
                        </svg>
                    </div>
                </div>
                <div class="estadistica-dato">
                    <p><?php echo $totalSolicitudes ?></p>
                    <h3>Total de Impresiones</h3>
                </div>
            </div>
        </div>

        <?php
        $añoActual = date('Y');

        // Conexión a la base de datos y consulta
        $query = "SELECT * FROM solicitudes WHERE YEAR (fecha) = $añoActual;";

        $resultado = mysqli_query($db, $query);

        // Array para almacenar el conteo de solicitudes por fecha
        $solicitudesPorFecha = [];

        while ($solicitud = mysqli_fetch_assoc($resultado)) {
            $fecha = $solicitud['fecha'];
            if (!isset($solicitudesPorFecha[$fecha])) {
                $solicitudesPorFecha[$fecha] = 0;
            }
            $solicitudesPorFecha[$fecha]++;
        }

        // Convierte el array a formato JSON para pasarlo a JavaScript
        $solicitudesPorFechaJson = json_encode($solicitudesPorFecha);
        ?>

        <script type="text/javascript">
            var solicitudesPorFecha = <?php echo $solicitudesPorFechaJson; ?>;
            var fechas = Object.keys(solicitudesPorFecha);
            var conteos = Object.values(solicitudesPorFecha);
        </script>

        <script type="text/javascript">
            var datosDesdePHP = {
                totalUsuarios: <?php echo json_encode($totalUsuarios); ?>,
                totalSolicitudes: <?php echo json_encode($totalSolicitudes); ?>
            };
        </script>



        <div class="graficas">
            <div class="grafica-barras">
                <div class="contenedor-filtro">
                    <h3>Solicitudes</h3>
                    <select class ="filtro-grafica" name="" id="">
                            <option value="">12 Meses</option>
                            <option value="">6 Meses</option>
                            <option value="">30 Dias</option>
                            <option value="">7 Dias</option>
                    </select>
                </div>
                <canvas id="chart-barras-fechas"></canvas>
            </div>
            <div class="grafica-pie">
                <div class="contenedor-filtro">
                    <h3>Estadisticas Generales</h3>
                </div>
                <canvas class="" id="chart-general"></canvas>
            </div>
            <h2>dsd</h2>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <script src="/js/chartjs.js"></script>
        <script src="/js/grafica.js"></script>
    </div>