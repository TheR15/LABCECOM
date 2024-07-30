<?php
require '../includes/database.php';
include '../includes/header.php';
require '../classes/Email.php';
$db = conectarDB();
$errores = [];
$contrasena = '';
$emailAdmin = '21940097@itstacambaro.edu.mx';
$contrasenaAdmin = '11721266';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $contrasena = mysqli_real_escape_string($db, $_POST['contrasena']);

    if (!$email || !$contrasena) {
        $errores = ['Los campos son obligatorios '];
    }

    if (empty($errores)) {
        //Verificar que el usuario exista

        $query = "SELECT * FROM usuarios WHERE email = '$email'";

        $resultado = mysqli_query($db, $query);
        //echo $query;
        $usuario = mysqli_fetch_assoc($resultado);
        
        $confirmado = $usuario['confirmado'];
        $idUsuario = $usuario['idUsuarios'];
        $nombre = $usuario['nombre'];

        if (mysqli_num_rows($resultado) > 0) {
            if ($usuario['confirmado'] === "1") {
                //Si existe
                $contrasenahash = $usuario['contrasena'];
                if (password_verify($_POST['contrasena'], $contrasenahash)) {
                    if ($emailAdmin === $email && password_verify($contrasenaAdmin, $contrasenahash)) {
                        $idUsuario = $usuario['idUsuarios'];
                        $nombre = $usuario['nombre'];
                        session_start();
                        $_SESSION['idUsuario'] = $idUsuario;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['login'] = true;
                        header("Location: ../admin/solicitudes.php");
                    } else {
                        session_start();
                        $_SESSION['idUsuario'] = $idUsuario;
                        $_SESSION['nombre'] = $nombre;
                        $_SESSION['login'] = true;
                        // Asegúrate de que $idUsuario y $nombre estén definidos y contengan los valores correctos
                        if (isset($_SESSION['idUsuario']) && isset($_SESSION['nombre'])) {
                            header("Location: ../usuario/solicitudes.php");
                            exit(); // Es recomendable usar exit después de header para asegurarse de que el script se detiene.
                        } else {
                            echo "Error al establecer las variables de sesión.";
                        }
                    }
                } else {
                    $errores = ['Contraseña incorrecta'];
                }
            } else {
                $errores = ['El usuario no esta confirmado'];
            }
        } else {
            //No existe
            $errores = ['El usuario no existe'];
        }
        //echo $query;
    }
}


?>

<body class="contenedor">
    <form class="formulario login" method="POST" action="login.php" novalidate>
        <div class="izquierda campos">
            <h1 class="centrar-texto">Iniciar Sesion</h1>

            <?php foreach ($errores as $error) : ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <h2>Correo</h2>
            <input class="input" type="email" placeholder="Ingrese su correo institucional" name="email">

            <h2>Contraseña</h2>
            <input class="input" type="password" placeholder="Ingrese su contraseña" name="contrasena">

            <p class="centrar-texto enlace-contrasena"><a class="" href="olvide.php">Recuperar contraseña</a></p>

            <input class="boton" type="submit" value="Iniciar Sesion">

            <p class="centrar-texto">¿Aún no tienes una cuenta? <a class="" href="crear.php">Registrate</a></p>
        </div>

        <div class="derecha">
            <img class="logo" src="/img/logo.png" alt="">
            <h2 class="centrar-texto">Laboratorio de Computo</h2>
        </div>
    </form>
</body>

</html>