<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = [
    	'idproveedor',
    	'idusuario',
    	'tipo_comprobante',
    	'serie_comprobante',
    	'num_comprobante',
    	'fecha_hora',
    	'impuesto',
    	'total',
    	'estado'
    ];

    //Obtiene el usuario que a registrado el ingreso
    public function usuario()
    {
    	return $this->belongsTo('App\User');
    }

    //Indica el proveedor
    public function proveedor()
    {
    	return $this->belongsTo('App\Proveedor');
    }
}
