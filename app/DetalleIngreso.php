<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
	//se asigna el nombre de la tabla a la que hacemos refernecia
	protected $table = 'detalle_ingresos';
    protected $fillable = [
    	'idingreso',
    	'idarticulo',
    	'cantidad',
    	'precio'
    ];

    public $timestamps = false;
}
