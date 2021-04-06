<?php

include_once "Usuario.php";

$archivoParaLeer = $_GET["listado"];

switch($archivoParaLeer)
{
    case "usuarios.csv":
        $arrayUsuarios = array();
        $arrayUsuarios = Usuario::LeerCsv($archivoParaLeer);
        Usuario::DibujarLista($arrayUsuarios);
        break;
    default:
        "ERROR. Archivo inexsistente";
    break;

}


?>