<?php
include_once "Usuario.php";

$clave = $_POST["clave"];
$mail = $_POST["mail"];


if(isset($clave) && isset($mail))
{
    $user = new Usuario(null,$clave, $mail);

    Usuario::VerificarUsuario($user);

}
else
{
    echo "Faltan cargar datos";
}


?>