<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // back retorna una respuesta en la página que llamó este archivo, with inserta un valor en la sesión
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)) return back()->with('mensaje', 'Credenciales Incorrectas');

        // si se logueó bien (el segundo argumento es un parámetro que se necesita en la url vinculada al nombre posts.index)
        return redirect()->route('posts.index', auth()->user()->username);


    }
}
