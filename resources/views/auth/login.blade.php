@extends('layouts.app')

@section('titulo')
    Inicia Sesión en DevStagram
@endsection

@section('contenido')

  <div class="md:flex justify-center md:gap-10 items-center">
    <div class="md:w-6/12 p-5">
      <img src="{{ asset('img/login.jpg') }}" alt="Imagen Login de Usuarios">
    </div>
    <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
      <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        @if(session('mensaje'))
          <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ session('mensaje') }}</p>
        @endif

        {{-- email --}}
        <div class="mb-5">
          <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
          <input 
            type="email" 
            id="email" 
            name="email" 
            placeholder="Tu Email de Registro" 
            class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
            value="{{ old('email') }}"
          >
        </div>

        @error('email')
          <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
        @enderror

        {{-- password --}}
        <div class="mb-5">
          <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Password de Registro</label>
          <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Pasword" 
            class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
          >
        </div>

        @error('password')
          <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
        @enderror

        <div class="mb-5">
          <input type="checkbox" name="remember" id="remember" />
          <label for="remember" class="text-gray-500 text-sm">Mantener mi sesión abierta</label>
        </div>

        <input 
          type="submit" 
          value="Iniciar Sesicón" 
          class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">

      </form>
    </div>
  </div>

@endsection