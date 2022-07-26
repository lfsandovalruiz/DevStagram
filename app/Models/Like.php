<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
			'user_id',
			// 'post_id' // no se requiere llenar este campo por que gracias a las relaciones, el método de crear un like será llamado sobre el model de post
    ];
}
