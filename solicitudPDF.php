<?php
require 'includes\database.php';
$db = conectarDB();

require 'vendor/autoload.php';  // Cargar autoload de Composer

use Dompdf\Dompdf;

// Verificar si se ha pasado el ID de la solicitud como parámetro
$idSolicitud = isset($_GET['idSolicitud']) ? intval($_GET['idSolicitud']) : 0;
$nombre= $_GET['nombre'];

if ($idSolicitud > 0) {
    // Obtener datos de la solicitud específica de la base de datos
        $sql = "SELECT solicitudes.*, usuarios.nombre AS nombre
            FROM solicitudes
            JOIN usuarios ON solicitudes.idUsuarios = usuarios.idUsuarios
            WHERE solicitudes.idSolicitud = $idSolicitud";

        $result = $db->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $solicitud = $result->fetch_assoc();
        
        // Crear instancia de DOMPDF
        $dompdf = new Dompdf();
        
        // Convertir imagen a base64
        $imagePath = './img/logo.png';
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $imagePath2 = './img/Logo-tec.png';
        $imageData2 = base64_encode(file_get_contents($imagePath2));
        $imageSrc2 = 'data:image/png;base64,' . $imageData2;

        $imagePath3 = './img/EDUCACION-LOGO.png';
        $imageData3 = base64_encode(file_get_contents($imagePath3));
        $imageSrc3 = 'data:image/png;base64,' . $imageData3;
        
        // Construir el contenido HTML con estilos CSS e imágenes

        setlocale(LC_TIME, 'es_Mx.UTF-8');
        $fecha = strftime('%A, %e de %B del %Y');

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Solicitud PDF</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                h1 {
                    text-align: center;
                    color: #333;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    /* Importante para que funcione border-radius */
                    border-spacing: 0;
                    border-radius: .5rem;
                    /* Borde redondeado */
                    overflow: hidden;
                    /* Para mantener el contenido dentro de los bordes redondeados */
                    font-size: 1.2rem;
                }
                table, th, td {
                    border: 1px solid #566573;
                }

                td{
                    background-color: #FDFEFE;
                }

                th, td {
                    text-align: left;
                    color: #17202A;
                    padding: .5rem;
                }
                th {
                    background-color: #EBF5FB;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                .logo {
                    text-align: center;
                    margin-bottom: 20px;
                    display:flex;
                    justify-content:space-between;
                    column-gap: 10px;

                }
                .logo img {
                    width: 125px;
                }

                .aa img{
                 width: 500px;
                 }

                .logo {
                    text-align: right; /* Alinea el contenido a la derecha */
                }

                .logos {
                    display: inline-block; /* Asegura que las imágenes se comporten como bloques en línea */
                    vertical-align: middle; /* Alinea verticalmente las imágenes si es necesario */
                    margin-right:3rem;
                    margin-left:3rem;
                }

                .logo-left {
                    text-align: left; /* Alinea el contenido a la izquierda */
                }

                .fecha{
                    font-size: 1.2rem;
                    text-align: right;
                    margin-bottom:3rem;
                    margin-top:3rem;
                }

                .firma{
                margin-top:8rem;
                text-align:center;
                }

                p{
                font-size: 1.1rem;
                 }

            </style>
        </head>
        <body>
            <div class="logo">
                <div class="logo-left">
                
                    <img class="logos ss" src="' . $imageSrc2 . '" alt="Logo">
                    <img class="logos rr" src="' . $imageSrc . '" alt="Logo">
                    <img class="logos ss" src="' . $imageSrc3 . '" alt="Logo">
                </div>
            </div>

        <h1 class="centrar-texto">Instituto Tecnologico Superior de Tacambaro</h1>

        <h2 class="fecha" >'. $fecha .'</h2> 

        <p>Nos complace confirmar que su solicitud de mantenimiento '.$solicitud['tipo'].'
        ha sido recibida y registrada con éxito. Nuestro equipo técnico 
        procederá con el mantenimiento programado según lo solicitado para garantizar el
        correcto funcionamiento y rendimiento óptimo del equipo.</p>
        <h2>Solicitud</h2> 
        <table>
            <tr><th>Nombre de solicitante</th><td>' . $solicitud['nombre'] . '</td></tr>
            <tr><th>ID Solicitud</th><td>' . $solicitud['idSolicitud'] . '</td></tr>
            <tr><th>Tipo</th><td>' . $solicitud['tipo'] . '</td></tr>
            <tr><th>Descripción</th><td>' . $solicitud['descripcion'] . '</td></tr>
            <tr><th>Lugar</th><td>' . $solicitud['lugar'] . '</td></tr>
            <tr><th>Fecha de solicitud</th><td>' . $solicitud['fecha'] . '</td></tr>
            <tr><th>Estado</th><td>' . $solicitud['estado'] . '</td></tr>
        </table>

        <div class="firma">
            <h2>Atentamente</h2> 
            <h2>Rodrigo Chavez Gonzalez</h2> 
        </div>
        </body>
        </html>
        ';
        
        // Cargar contenido HTML a DOMPDF
        $dompdf->loadHtml($html);
        
        // (Opcional) Configurar el tamaño y orientación del papel
        $dompdf->setPaper('A4', 'portrait');
        
        // Renderizar el PDF
        $dompdf->render();
        
        // Salida del PDF al navegador
        $dompdf->stream("solicitud_$idSolicitud.pdf", array("Attachment" => false));
    } else {
        echo "No se encontraron datos para la solicitud con ID $idSolicitud.";
    }
} else {
    echo "ID de solicitud no válido.";
}
?>
