<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        // aquí llega la imagen que se selecciona (llega tan solo al seleccionar imagen) en el dropzone (accesible a traves de file)
        $imagen = $request->file('file');

        dd($imagen);

        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        // modificamos la imagen a nuestro gusto
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000);

        // creamos en public una carpeta llamada uploads y guardamos ahí la imagen
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
    }
}
