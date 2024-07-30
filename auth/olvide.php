<?php
    use Classes\Email;
    include '../includes/header.php';
    require '../includes/database.php';
    require '../classes/Email.php';
    
    $db=conectarDB();
    $errores=[];

    $email = '';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string($db, $_POST['email']);
        
        if(!$email){
            $errores[] = "El email es obligatorio";
        }

        if(empty($errores)){
            //Buscar el usuario

            $query = "SELECT * FROM usuarios WHERE email = '$email';";
            //echo $query;
            $resultado = mysqli_query($db,$query);

            if(mysqli_num_rows($resultado)>0){
                //Encontre al usuario

                $usuario = mysqli_fetch_assoc($resultado);

                if($usuario['confirmado'] === "1"){
                    //EL usuario SI esta confirmado
                    
                    //Generar un nuevo token
                    $token = uniqid();

                    //Actualizamos el usuario con su nuevo token
                    $query = "UPDATE usuarios SET token = '$token' WHERE idUsuarios = {$usuario['idUsuarios']};";
                    
                    $resultado = mysqli_query($db,$query);

                    if($resultado){
                        $exitos[] = "HEMOS ENVIADO LAS INSTRUCCIONES A TU EMAIL";
                    }

                    //Enviar email
                    $nombre = $usuario['nombre'];

                    $mail = new Email($email ,$nombre, $token);
                    $mail -> enviarInstrucciones();


                    //Imprimimos la alerta

                }else{
                    //EL usuario NO esta confirmado
                    $errores[] = "El usuario no esta confirmado";
                }


            }else{
                //No existe el email
                $errores[] = "El usuario no existe";
            }

        }
    }
?>

<body class="contenedor">
    <form class="formulario login formulario-olvide" method="POST" action="olvide.php"  novalidate>
        <div class="izquierda campos">
            <h1 class="centrar-texto referencia">Recuperar contraseña</h1>
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
            <h2>Correo</h2>
            <input id= "email" class="input" type="email" placeholder="Ingrese su correo institucional" name="email">

            <input id = "submit" class="boton boton-olvide" type="submit" value="Enviar instrucciones">
                    
            <p class="centrar-texto">¿Ya tienes una cuenta? <a class="" href="login.php">Inicia Sesion</a></p>
        </div>

        <div class="derecha olvide">
            <img class="logo" src="/img/logo.png" alt="">
            <h2 class="centrar-texto">Laboratorio de Computo</h2>
        </div>
    </form>
</body>
<script src="/js/validacion.js"></script>
</html>