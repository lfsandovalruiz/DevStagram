<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function __construct()
    {
        // antes de llamar cual quier método de esta clase se verifica si hay un usuario autenticado (si no, manda al login)
        $this->middleware('auth')->except(['show', 'index']);
    }

    // $user es la información completa del usuario encontrado en BD a traves del parámetro en la función que esta llamando esta función 
    // esta funcion es index; la función que esta llamando esta función esta en web.php
    public function index(User $user)
    {

        // buscar los posts donde el usuario 'user_id' sea igual al usuario dado
        // $posts = Post::where('user_id', $user->id)->get(); // obtiene todos los registros 
        $posts = Post::where('user_id', $user->id)->paginate(12); // obtiene los registros pero paginados, en este caso 5

        // dd($user); // aquí tenemos disponible la información del usuario
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
    
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // // Post es el nombre del modelo (no el tipo de solicitud)
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        // // otra forma de hacer lo de arriba
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;        
        // $post->user_id = auth()->user()->id;
        // $post->save();

        // otra forma de guardar en base de datos

        // posts() es la función del modelo de User (se tiene que llamar igual)
        // se puede leer así: accedemos al usuario logueado, accedemos a su relación posts y creamos un registro en esa relación
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);


        return redirect()->route('posts.index', auth()->user()->username);
    }

    // la url vinculada a este método necesita 2 parametros (por eso tenemos 2 argumentos), pero no enviamos $user por que no lo usaremos
    public function show(User $user, Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
      // si vemos el método delete en PostPolicy.php este recibe 2 parámetros (User $user, Post $post), pero sólo le enviamos uno ($post)...
      // ...por que $user ya lo tiene jeje
      $this->authorize('delete', $post);

      // si se pasa la validación de arriba validación podemos borrar
      $post->delete();

      // eliminamos la imagen del proyecto
      $imagen_path = public_path('uploads' . $post->imagen);

      // revisar que exista el archivo
      if(File::exists($imagen_path)){
        unlink($imagen_path);
      }

      return redirect()->route('posts.index', auth()->user()->username);
    }
}
