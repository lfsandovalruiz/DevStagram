<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
      'titulo',
      'descripcion',
      'imagen',
      'user_id'
    ];

    public function user()
    {
      return $this->belongsTo(User::class)->select(['name', 'username']); // indicamos qué datos queremos traer
    }

    public function comentarios()
    {
      return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
      return $this->hasMany(Like::class);
    }

    // revisar si un like esta vinculado a un usuario (para que no lo de dos veces)
    public function checkLike(User $user)
    {
      // revisar en la base de datos en la tabla de likes en su columna 'user_id', los likes que perteneces a este post con el user_id indicado
      return $this->likes->contains('user_id', $user->id);
    }

}
