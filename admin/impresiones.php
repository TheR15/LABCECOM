<?php
    $titulo = 'Impresiones';
    session_start();
    if(!isset($_SESSION['login'])){
        header('Location: ../auth/login.php');
    }
    ?>
    <div class="dashboard">
    <?php
    include '../includes/sidebar.php';
    ?>
    <?php
    require '../includes/database.php';
    include '../includes/header.php';
    $db = conectarDB();

    ?>

<div class="contenido">
    <h1 class="centrar-texto"><?php echo $titulo?></h1>
</div>