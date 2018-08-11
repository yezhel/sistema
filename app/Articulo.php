<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
	//eloquent-relationships
    protected $fillable = [
    	'icategoria','codigo','nombre','precio_venta','stock','descripcion','condicion'
    ];

    //NOTA:Un articulo pertenece a una categoria y una categoria tiene varios articulos
    public function categoria()
    {
    	//Relacion uno a uno, un articulo pertenece a una categoria
    	return $this->belongsTo('App\Categoria');
    }
}
