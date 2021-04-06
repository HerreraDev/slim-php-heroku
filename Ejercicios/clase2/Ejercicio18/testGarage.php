/******************************************************************************

Herrera Martín

Aplicación No 18 (Auto - Garage)
Crear la clase Garage que posea como atributos privados:

_razonSocial (String)
_precioPorHora (Double)
_autos (Autos[], reutilizar la clase Auto del ejercicio anterior)

Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

i. La razón social.
ii. La razón social, y el precio por hora.

Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y
que mostrará todos los atributos del objeto.
Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage”
(sólo si el auto no está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Add($autoUno);
Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del
“Garage” (sólo si el auto está en el garaje, de lo contrario informarlo).
Ejemplo: $miGarage->Remove($autoUno);
En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los
métodos.

Este archivo es testGarage.php, pero dice "source code" porque no se renombrarlo en gdb.
*******************************************************************************/
<?php

include_once "Garage.php";

$auto1 = new Auto("Renault", "Verde", 61510);
$auto2 = new Auto("Peugeot", "Amarillo", 746844);
$auto3 = new Auto("Ford", "Rojo", 5151351);
$auto4 = new Auto("Chevrolet", "Azul", 687645);

$garage1 = new Garage("El garage S.A", 88.2);

Echo "MUESTRO EL GARAGE VACIO:", "<br/>";
$garage1->MostrarGarage();

Echo "AÑADO UN AUTO", "<br/>";
$garage1->Add($auto1);

Echo "MUESTRO EL GARAGE CON UN AUTO:", "<br/>";
$garage1->MostrarGarage();

Echo "INTENTO AÑADIR EL MISMO AUTO:", "<br/>";
$garage1->Add($auto1);

Echo "AÑADO LOS OTROS TRES AUTOS Y MUESTRO EL GARAGE", "<br/>";
$garage1->Add($auto2);
$garage1->Add($auto3);
$garage1->Add($auto4);
$garage1->MostrarGarage();

Echo "ELIMINO EL TERCER AUTO Y MUESTRO EL GARAGE: ", "<br/>";
$garage1->Remove($auto3);
$garage1->MostrarGarage();

Echo "INTENTO ELIMINAR TERCER AUTO DE NUEVO: ", "<br/>";
$garage1->Remove($auto3);



?>
