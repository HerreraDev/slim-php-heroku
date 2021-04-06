<?php

include_once "Usuario.php";


if(isset($_POST["nombre"]) && isset($_POST["clave"]) && isset($_POST["mail"]) && $_FILES["foto"]["error"] == 0)
{


    $destino = "usuario/fotos/" . $_FILES["foto"]["name"];
    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];
    $mail = $_POST["mail"];

    $user = new Usuario($nombre, $clave, $mail, $destino);
        

    if(Usuario::GuardarJsonEImagen($user))
    {
        echo "Usuario registrado con exito!"
    }
    else
    {
        echo "Fallo el guardado del JSON o el mover la imagen";
    }

    
}
else
{
    echo "Faltan datos";
}



?>