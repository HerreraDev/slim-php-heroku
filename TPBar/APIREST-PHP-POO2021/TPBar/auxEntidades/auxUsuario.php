<?php

require_once './fpdf183/fpdf.php';
require_once './models/Usuario.php';

use App\Models\Usuario as Usuario;

class auxUsuario
{


    public static function VerificarUsuarioDB($user)
    {

        $arrayUsuarios = array();
        $arrayUsuarios = Usuario::all();

        $verificado = -1;
        foreach ($arrayUsuarios as $usuario) {
            if ($usuario->mail == $user->mail) {

                if ($usuario->clave == $user->clave) {
                    $verificado = 1;
                    $user->empleo = $usuario->empleo;
                } else {
                    $verificado = 0;
                }
            }
        }
        return $verificado;
    }

    public static function mostrarDatos($usuario)
    {
        return $usuario->idUsuario.",".$usuario->nombre . "," . $usuario->apellido . "," . $usuario->clave . "," . $usuario->mail . "," . $usuario->empleo . "," . $usuario->fecha_de_ingreso.",".$usuario->ruta_foto.",".$usuario->fecha_de_salida;
    }


    public static function ObtenerIdPorMail($mail)
    {

        $arrayUsuarios = array();
        $arrayUsuarios = Usuario::all();

        $idUsuario = -1;
        foreach ($arrayUsuarios as $usuario) {
            if ($usuario->mail == $mail) {
                $idUsuario = $usuario->idUsuario;
                break;
            }
        }
        return $idUsuario;
    }

    public static function ObtenerIdCliete($mailCliente)
    {

        $arrayUsuarios = array();
        $arrayUsuarios = Usuario::all();

        $idCliente = -1;
        foreach ($arrayUsuarios as $usuario) {
            if ($usuario->mail == $mailCliente && $usuario->empleo == "Cliente") {
                $idCliente = $usuario->idUsuario;
                break;
            }
        }
        return $idCliente;
    }



    //--------------------------------------------------//
    //CSV

    public static function GuardarEnCsv($usuario, $mode)
    {

        $direccionArchivo = fopen("csv/Usuarios.csv", $mode);

        if ($direccionArchivo != false) {
            if (fwrite($direccionArchivo, auxUsuario::mostrarDatos($usuario). "\n") != false) {
                fclose($direccionArchivo);
                return 1;
            } else {
                fclose($direccionArchivo);
                return 0;
            }
        }
    }

    public static function GenerarCSV()
    {

        $usuarios = array();
        $usuarios = Usuario::all();

        $mode = "w";

        foreach ($usuarios as $user) {
            self::GuardarEnCsv($user, $mode);
            $mode = "a";
        }

        echo "Csv generado en la ruta /csv/Usuarios.csv";
    }



    // public static function LeerDeJson($archivo){

    //     $vec = array();
    //     $productos = array();
    //     $archivo = fopen($archivo, "r");


    //     if($archivo != false){

    //         while(!feof($archivo))
    //         {
    //             $lectura = fgets($archivo);
    //             $vec = json_decode($lectura, true);

    //             if($vec != null)
    //             {
    //                 $prod = new Pizza($vec["idPizza"],$vec["sabor"],$vec["precio"],$vec["tipo"], $vec["cantidad"]);

    //                 array_push($productos,$prod); 
    //             }

    //         }

    //         fclose($archivo);
    //     }

    //     return $productos;
    // }

    public static function GenerarPdf()
    {
        $lista = Usuario::all();

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        foreach ($lista as $user) {
            $pdf->Cell(40, 10, $user->nombre,1, 0, 'C',0);
            $pdf->Cell(40, 10, $user->apellido,1,0,'C',0);
            $pdf->Cell(40, 10, $user->empleo,1,0,'C',0);
            $pdf->Cell(40, 10, $user->fecha_de_ingreso,1,1,'C',0);

        }

        echo $pdf->Output("usuarios.pdf","F");

        echo "Pdf de usuarios generado en /pdf/usuarios.pdf";
    }


}
