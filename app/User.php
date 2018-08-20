<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'usuario', 'password','condicion', 'idrol'
    ];

    //deshabilita los campos timestamps
    public $timestamps = false;
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //hace referencia al modelo rol
    public function rol()
    {
        //un usuario pertenece a un rol
        return $this->belongsTo('App\Rol');
    }

    public function persona()
    {
        //un usuario hace referencia a una persona
        return $this->belongsTo('App\Persona');
    }
}
