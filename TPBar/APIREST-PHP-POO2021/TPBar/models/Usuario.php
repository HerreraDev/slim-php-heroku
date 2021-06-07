<?php

namespace App\Models;


require_once "../vendor/autoload.php";


use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes as SoftDeletes;
 
class Usuario extends Eloquent { 
    
    use SoftDeletes;

    protected $primaryKey = 'idUsuario';
    protected $table = 'usuario';
    public $incrementing = true;
    public $timestamps = false;

    const DELETED_AT = 'fecha_de_salida';

    protected $fillable = [
        'idUsuario', 'nombre', 'apellido', 'clave', 'mail', 'fecha_de_ingreso', 'empleo', 'ruta_foto', 'fecha_de_salida'
    ];
}











?>