<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    public function index() {
        $posts = Post::all();
        return view('guests.index', compact('posts'));
    }

    public function show($slug) {
        $post = Post::where('slug', $slug)->first(); # first per velocizzare la ricerca, si ferma appena lo trovo

        $my_id = Auth::id();
        $flag = false;
        if ($my_id == $post->user_id) {
            $flag = true;
        }

        return view('guests.show', compact('post', 'flag'));
    }
}
