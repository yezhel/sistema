<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        //propiedad usuario sea igual a la propiedad usuario del objeto rquest que sera recibido via ajax
        if(Auth::attempt(['usuario' => $request->usuario,'password'=> $request->password,'condicion'=>1]))
        {
            return redirect()->route('main');
        }

        //redirecciona atras, withErrors para mostrar posibles errores en el login
        return back()
            ->withErrors(['usuario' => trans('auth.failed')]);//identificador de la plantilla blade a mostrar y el error
            ->withInput(request(['usuario']));
    }

    protected function validateLogin(Request $request)
    {
        //valores a validar
        $this->validate($request,[
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);
    }
}
