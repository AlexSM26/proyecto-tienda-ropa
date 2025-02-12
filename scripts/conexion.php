<?php
$server = 'localhost:3310';
$user = 'root';
$pass = '';
$db = 'tienda_ropa';


$connection = new mysqli($server, $user, $pass, $db);


if($connection -> connect_errno){
    die('Error al conectar: '. $connection -> connect_error);
}else{
    echo 'Conectado correctamente';
}
?>