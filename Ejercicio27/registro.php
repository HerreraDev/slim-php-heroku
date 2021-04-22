<?php

include_once "./clases/usuario.php";


if(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["clave"]) && isset($_POST["mail"]) && isset($_POST["localidad"]) && isset($_POST["fechaDeRegistro"]))
{
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $clave = $_POST["clave"];
    $mail = $_POST["mail"];
    $localidad = $_POST["localidad"];
    $fechaDeRegistro = $_POST["fechaDeRegistro"];


    $user = new Usuario($nombre, $apellido, $clave, $mail, $localidad, $fechaDeRegistro);
        
    echo $user->InsertarElUsuarioParametros();
}
else
{
    echo "Faltan datos";
}



?>