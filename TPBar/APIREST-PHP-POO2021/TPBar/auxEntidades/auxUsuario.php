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
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->mail == $user->mail)
            {

                if($usuario->clave == $user->clave)
                {
                    $verificado = 1;
					$user->empleo = $usuario->empleo;
                }
                else
                {
                    $verificado = 0;
                }
            }
        }
		return $verificado;
	}

	public function mostrarDatos()
	{
        return "Datos:".$this->nombre."  ".$this->apellido." ".$this->clave." ".$this->mail." ".$this->empleo." ".$this->fecha_de_ingreso;
	}

	public static function GenerarPdf()
	{
		$lista = self::TraerTodoLosUsuarios();

		$string = "";
		foreach($lista as $user){
			foreach($user as $item){
				$string = $string . $item;
			}
		}

		echo $string;

		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,$string);
		$pdf->Output('./pdfs/users.pdf','F');

		echo "pdf generado";
	}

	public static function ObtenerIdPorMail($mail)
    {

        $arrayUsuarios = array();
        $arrayUsuarios = Usuario::all();

        $idUsuario = -1;
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->mail == $mail)
            {
                $idUsuario = $usuario->idUsuario;
				break;
            }
        }
		return $idUsuario;
	}

	public static function ObtenerIdCliete($mailCliente){

		$arrayUsuarios = array();
        $arrayUsuarios = Usuario::all();

        $idCliente = -1;
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->mail == $mailCliente && $usuario->empleo == "Cliente")
            {
                $idCliente = $usuario->idUsuario;
				break;
            }
        }
		return $idCliente;
	}
}
   

























?>