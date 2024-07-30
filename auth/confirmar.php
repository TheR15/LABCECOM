<?php
include '../includes/header.php';
require '../includes/database.php';
$db = conectarDB();

$token = $_GET['token'];
//echo $token;

if (!$token) {
    header('Location: /auth/login.php');
    exit;
}

// Encontrar al usuario con este token
$query = "SELECT * FROM usuarios WHERE token = '$token';";
$resultado = mysqli_query($db, $query);

if (mysqli_num_rows($resultado) > 0) {
    // Obtener los datos del usuario
    $usuario = mysqli_fetch_assoc($resultado);

    // Confirmar la cuenta
    $confirmado = 1;
    $token = null;

    // Actualizar el valor de confirmado a 1 y token a null
    $query = "UPDATE usuarios SET confirmado = '$confirmado', token = NULL WHERE idUsuarios = {$usuario['idUsuarios']}";
    $resultado_update = mysqli_query($db, $query);

    if ($resultado_update) {
        $exitos[] = "Cuenta comprobada correctamente";
    } else {
        echo "Error al confirmar la cuenta: " . mysqli_error($db);
    }
    } else {
        // No se encontró un usuario con este token
        $errores[] = "Token no válido";
    }


?>

<body class="contenedor">
    <div class="formulario login">
        <div class="izquierda campos">

            <?php foreach ($errores as $error) : ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <?php foreach ($exitos as $exito) : ?>
                <div class="alerta-exito">
                    <?php echo $exito; ?>
                </div>
            <?php endforeach; ?>

            <p class="centrar-texto"><a class="" href="login.php">Iniciar Sesion</a></p>
        </div>

        <div class="derecha confirmar">
            <img class="logo" src="/img/logo.png" alt="">
            <h2 class="centrar-texto">Laboratorio de Computo</h2>
        </div>
    </div>
</body>

</html>