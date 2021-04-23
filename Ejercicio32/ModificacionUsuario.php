<?php

include_once "./clases/Usuario.php";

if(isset($_POST["nombre"]) && isset($_POST["clavenueva"]) && isset($_POST["clavevieja"]) && isset($_POST["mail"]))
{

    $nombre = $_POST["nombre"];
    $claveNueva = $_POST["clavenueva"];
    $claveVieja = $_POST["clavevieja"];
    $mail = $_POST["mail"];

    $user = Usuario::constructorParametrizado($nombre,null,$claveVieja,$mail,null,null);

    if(Usuario::ModificarContraseñaUserBD($user,$claveNueva))
    {
        echo "Contraseña modificada con exito";
    }
    else
    {
        echo "No se pudo cambiar la contraseña";
    }

 
    
}
else
{
    echo "Faltan datos";
}


?>