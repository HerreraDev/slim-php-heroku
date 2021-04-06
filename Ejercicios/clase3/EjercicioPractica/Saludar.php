<?php 

echo "va por GET <br>";
var_dump($_GET);


echo " <br> var por POST <br>";
var_dump($_POST);


//validar si el $_POST["nombre"] esta cargado.
echo "<br> Bienvenido/a ", $_POST["txtNombre"];



?>