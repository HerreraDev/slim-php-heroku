<?php

include_once "Usuario.php";


if(isset($_POST["nombre"]) && isset($_POST["clave"]) && isset($_POST["mail"]))
{
    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];
    $mail = $_POST["mail"];

    $user = new Usuario($nombre, $clave, $mail);
        
    if($user->Guardar())
    {
        echo "Se guardo correctamente";
    }
}
else
{
    echo "Faltan datos";
}



?>