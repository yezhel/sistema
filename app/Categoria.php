<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	//Indica la tabla con la que se trabaja
    //protected $table = 'categorias';

	//Indica la llave primarya
    // protected $primaryKey = 'id';
    
    //Define los atributos que se quieren asignar valores en masa
    protected $fillable = ['nombre','descripcion','condicion'];

    public function articulos()
    {
    	//One To Many, una categoria puede tener varios articulos
        return $this->hasMany('App\Articulo');
    }
}
