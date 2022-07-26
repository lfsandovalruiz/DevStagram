<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Post;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
        // return $this->hasMany(Post::class, 'user_id'); // en caso de que no detecte la llave foranea se la pasamos como argumento (para cuando tiene un nombre que no respeta las convenciones de Laravel)
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Almacenar seguidores de un usuario
    public function followers()
    {
        // indicamos la tabla y los demas datos por que no la va a reconocer (por que nos salimos de la covención de Laravel)
        // podríamos leerlo así: en la tabla followers un usuario puede tener muchos seguidores
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }
    
    // Almacenar los usuarios que seguimos
    public function followings()
    {
        // indicamos la tabla y los demas datos por que no la va a reconocer (por que nos salimos de la covención de Laravel)
        // podríamos leerlo así: en la tabla followers un seguidor puede seguir a muchos usuarios
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    // Comprobar si un usuario ya sigue a otro
    public function siguiendo(User $user)
    {
        return $this->followers->contains($user->id);
    }

    
}
