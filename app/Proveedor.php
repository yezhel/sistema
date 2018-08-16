<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
	//Espesificamos la tabla a la que hacemos referencia 
    protected $table = 'proveedores';
    protected $fillable = [
    			'id', 'contacto', 'telefono_contacto'
    		];

    //Desactivamos el created_at y update_at
    public $timestamps = false;

    //un proveedor pertenece a una persona
    public function persona()
    {
    	return $this->belongsTo('App\Persona');
    }
}
