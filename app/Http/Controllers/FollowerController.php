<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
  public function store(User $user /*, Request $request  // solo requerimos el id y se puede sacar de auth()  */)
  {
    // se leería así: el usuario al que se le da seguir se le agrega en la tabla de followers el usuario que esta dando seguir (o sea el que esta logueado)
    // cuando se relaciona con la misma tabla se usa el método attach
    $user->followers()->attach( auth()->user()->id );

    return back();

  }

  public function destroy(User $user)
  {
    $user->followers()->detach( auth()->user()->id );

    return back();

  }
}
