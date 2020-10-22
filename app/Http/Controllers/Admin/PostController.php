<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller {
    protected $validation = [
        'title' => 'required|min:5|max:100',
        'body' => 'required|min:5|max:500',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        // seleziono solo i post dell'utente autenticato
        $posts = Post::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $tags = Tag::all();
        return view('admin.posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->all();
        $request->validate($this->validation);
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'], '-');

        $newPost = new Post;
        $newPost->fill($data);
        $result = $newPost->save();
        // $newPost = Post::create($data);

        $newPost->tags()->attach($data['tags']);

        if ($result) {
            return redirect()->route('posts.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post) {
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) {
        $data = $request->all();
        $request->validate($this->validation);
        $data['slug'] = Str::slug($data['title']);

        // sync tags
        $post->tags()->sync($data['tags']);
        $post->update($data);

        // scrittura alternativa a redirect()->route()
        return redirect(route('posts.index'))->with('status', ['success', 'Post updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        $post->delete();
        return redirect(route('posts.index'))->with('status', ['danger', "{$post->user->name}, you have deleted your post!"]);
    }
}
