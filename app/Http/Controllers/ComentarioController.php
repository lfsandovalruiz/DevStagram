<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    // $request viene del formulario, $user y $post vienen de la url (estos dos estan en orden, no usaremos $user solo lo recibimos para que no de error) 
    public function store(Request $request, User $user, Post $post)
    {
        
        // validar
        $this->validate($request, [
          'comentario' => 'required|max:255'
        ]);

        Comentario::create([
          'user_id' => auth()->user()->id, // queremos el usuario que esta comentando (no al que le estan comentando)
          'post_id' => $post->id,
          'comentario' => $request->comentario
        ]);

        // la variable mensaje se creará en la sesión, por lo que para leer su valor se tiene que hacer con session('mensaje)
        return back()->with('mensaje', 'Comentario Realizado Correctamente');
        
    }
}
