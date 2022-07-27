<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    // cuando solo se necesite una función, la funcionalidad se puede poner en __invoke (para que cuando se mande llamar la clase se ejecute esta función)
    public function __invoke()
    {
        return view('home');
    }
    
}
