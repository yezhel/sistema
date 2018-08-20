<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre', 'tipo_documento','num_documento','direccion','telefono','email'];

    //una persona esta relacionada con solo un proveedor
    public function proveedor()
    {
    	return $this->hasOne('App\Proveedor');
    }

    public function user()
    {
    	//indica que una persona esta relacionada directamente con un usuario
    	return $this->hasOne('App\User');
    }
}
