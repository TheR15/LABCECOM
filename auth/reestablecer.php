<?php
include '../includes/header.php';
require '../includes/database.php';
require '../classes/Email.php';

$db = conectarDB();
$errores = [];

$token = $_GET['token'];
$mostrar = true;
//echo $token;

if (!$token) {
    header('Location: login.php');
}
//Buscar el usuario con el token
$query = "SELECT * FROM usuarios WHERE token = '$token';";
//echo $query;

$resultado = mysqli_query($db, $query);

if (mysqli_num_rows($resultado) > 0) {
    //Token Valido


} else {
    //Token no valido y no se muestra el formulario
    $errores = ['Token No Valido'];
    $mostrar = false;
}

$contrasena = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contrasena = mysqli_real_escape_string($db, $_POST['contrasena']);
    $usuario = mysqli_fetch_assoc($resultado);

    if (strlen($contrasena) < 6) {
        $errores = ['La contraseña debe contener al menos 6 caracteres'];
    }

    if (!$contrasena) {
        $errores = ['La contraseña no puede ir vacia'];
    }



    if (empty($errores)) {
        //Hasheamos la nueva contrasena
        $contrasenahash = password_hash($contrasena, PASSWORD_BCRYPT);

        $idUsuario = $usuario['idUsuarios'];
        //Redireccionar

        $query = "UPDATE usuarios SET contrasena = '$contrasenahash', token = NULL WHERE idUsuarios = 
        $idUsuario;";

        $resultado = mysqli_query($db,$query);

        if($resultado){
            header('Location: login.php');
        }
    }
}

?>

<body class="contenedor">
    <form class="formulario login" method="POST">
        <div class="izquierda campos">
            <h1 class="centrar-texto">Coloca tu nueva contraseña</h1>

            <?php foreach ($errores as $error) : ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <?php if ($mostrar) { ?>
                <h2>Contraseña</h2>
                <input class="input" type="password" placeholder="Ingrese su contraseña" name="contrasena">

                <input class="boton boton-restablecer" type="submit" value="Guardar contraseña">

            <?php } ?>

            <p class="centrar-texto">¿Aún no tienes una cuenta? <a class="" href="crear.php">Registrate</a></p>
        </div>

        <div class="derecha restablecer">
            <img class="logo" src="/img/logo.png" alt="">
            <h2 class="centrar-texto">Laboratorio de Computo</h2>
        </div>
    </form>
</body>

</html>