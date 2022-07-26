<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return back();
    }

    public function destroy(Request $request, Post $post)
    {
      // de todos los likes que pertenecen al usuario, buscar uno con el id del post, y borrarlo
      $request->user()->likes()->where('post_id', $post->id)->delete();

      return back();
      
    }

}
