<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rol extends Model
{
	//Hace referencia a la tabla roles
    protected $table = 'roles';
    //Los campos de donde vamos a obtener y enviar valores
    protected $fillable = ['nombre', 'descripcion','condicion'];
    //Deshabilitamos el timestamp
    public $timestamps = false;

    public function users()
    {
    	//un rol puede tener varios usuarios
    	return $this->hasMany('App\User');
    } 
}
