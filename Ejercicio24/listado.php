<?php

include_once "Usuario.php";

$archivoParaLeer = $_GET["listado"];

switch($archivoParaLeer)
{
    case "usuarios.json":
        $arrayUsuarios = array();
        $arrayUsuarios = Usuario::LeerDeJson($archivoParaLeer);
        Usuario::DibujarListaJSON($arrayUsuarios);
        break;
    default:
        "ERROR. Archivo inexsistente";
    break;

}


?>