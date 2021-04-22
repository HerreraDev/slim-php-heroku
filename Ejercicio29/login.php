<?php
include_once "./clases/Usuario.php";

$clave = $_POST["clave"];
$mail = $_POST["mail"];


if(isset($clave) && isset($mail))
{
    $user = Usuario::constructorParametrizado(null, null,$clave, $mail,null, null);

    Usuario::VerificarUsuarioDB($user);

}
else
{
    echo "Faltan cargar datos";
}


?>