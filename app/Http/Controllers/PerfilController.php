<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('perfil.index');
    }

    // aquí se edita la información del perfil
    public function store(Request $request)
    {

        $request->request->add(['username' => Str::slug($request->username)]);

        // al ser mas de 3 reglas de validación Laravel recomienda pasarlas a arreglo
        /** IMPORTANTE **/
        // "'unique:users,username,' . auth()->user()->id" crea esto (ejemplo): 'unique:users,username,10'
        // puede leerse así: el username no se puede repetir, pero sí se puede repetir donde tenga el id de 10
        // lo cual indica que no se puede repetir un username con otro pero sí se puede repetir el username (se tiene que volver a especificar por que por defecto revisa la columna name) de la fila con el id de 10 (para este ejemplo)
        // lo cual es para permitir que SÍ SE REPITA el username que YA TENÍA
        $this->validate($request, [
            'username' => ['required', 'unique:users,username,' . auth()->user()->id, 'min:3', 'max:20', 'not_in:twitter,editar-perfil'],
        ]);

        if($request->imagen){
          // aquí llega la imagen que se selecciona (llega tan solo al seleccionar imagen) en el dropzone (accesible a traves de file)
          $imagen = $request->file('imagen');

          $nombreImagen = Str::uuid() . "." . $imagen->extension();

          // modificamos la imagen a nuestro gusto
          $imagenServidor = Image::make($imagen);
          $imagenServidor->fit(1000, 1000);

          // creamos en public una carpeta llamada uploads y guardamos ahí la imagen
          $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
          $imagenServidor->save($imagenPath);
        }
        
        // guardar comentarios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        // redireccionar
        return redirect()->route('posts.index', $usuario->username);

    }

}
