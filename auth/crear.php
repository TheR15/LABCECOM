<?php
use Classes\Email;
    include '../includes/header.php';
    require '../includes/database.php';
    require '../classes/Email.php';
    
    $db=conectarDB();
    $errores=[];

    $nombre = '';
    $email = '';
    $contrasena = '';
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $contrasena = mysqli_real_escape_string($db, $_POST['contrasena']);

        //Comprobar si ya existe un usuario con el mismo correo
        $query = "SELECT * FROM usuarios WHERE email = '$email';";
        //echo $query;
        $resultado = mysqli_query($db,$query);

        //echo mysqli_num_rows($resultado);
        
        if (!preg_match('/^([a-z0-9_\.-]+)@itstacambaro\.edu.mx$/', $email)) {
            $errores[] = "Solo cuentas del Tecnologico";
        }else
        if(mysqli_num_rows($resultado)>0){
            $errores[] = "El usuario ya esta registrado";
            
        }else{
            //Hashear contrasena
            $contrasenahash = password_hash($contrasena, PASSWORD_BCRYPT);

            //Generar token de confirmacion
            $token = uniqid(); //md5 retorna 32 caracteres

            $confirmado = 0;
            
            $mail = new Email($email, $nombre, $token);
            $mail->enviarConfirmacion();


            $query = "INSERT INTO usuarios (nombre,contrasena,email,token,confirmado)
            VALUES ('$nombre','$contrasenahash','$email','$token','$confirmado');";

            $resultado = mysqli_query($db,$query);
            
            //Enviar email
            
            if($resultado){   
                header('Location: mensaje.php');
            }
        }
    }

?>

<body class="contenedor">
    <form class="formulario" method="POST" action="crear.php">
        <div class="izquierda campos">
            <h1 id ="referencia" class="centrar-texto">Registrarse</h1>

            <?php foreach ($errores as $error) : ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <h2>Nombre</h2>
            <input class="input input-registro" id="nombre" type="text" placeholder="Ingrese su nombre" name="nombre" value="<?php echo $nombre; ?>">

            <h2>Correo</h2>
            <input class="input input-registro" id="email" type="text" placeholder="Ingrese su correo institucional" name="email"  value="<?php echo $email; ?>">

            <h2>Contraseña</h2>
            <input class="input input-registro" id="contrasena" type="password" placeholder="Ingrese su contraseña" name="contrasena">

            <h2>Repetir contraseña</h2>
            <input class="input  input-registro" id="contrasena2"type="password" placeholder="Ingrese nuevamente su contraseña" name="contrasena2">

            <input class="boton boton-registro" type="submit" value="Crear cuenta">

            <p class="centrar-texto">¿Ya tienes una cuenta? <a class="" href="login.php">Inicia Sesion</a></p>

        </div>
        <div class="derecha crear">
            <img class="logo logo-registro" src="/img/logo.png" alt="">
            <h2 class="centrar-texto">Laboratorio de Computo</h2>
        </div>
    </form>
</body>
<script src="/js/validacion.js"></script>
</html>