<?php
function conectarDB() : mysqli {
    $db = mysqli_connect('localhost','root','11721266','laboratorio',3306);

    if(!$db){
        echo "Hubo un error" . mysqli_connect_error();
        exit;
    }else{
        
    }
    return $db;

}
conectarDB();