<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller {
    protected function validation($flag, $post = null) {
        if ($flag == 'store') {
            return [
                'title' => 'unique:posts|required|min:5|max:100',
                'body' => 'required|min:5|max:500',
                'img' => 'image',
            ];
        } elseif ($flag == 'update') {
            return [
                'title' => [Rule::unique('posts')->ignore($post), 'required', 'min:5', 'max:100'],
                'body' => 'required|min:5|max:500',
                'img' => 'image',
            ];
        }
    }
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
    public function store(Request $request, Faker $faker) {
        $data = $request->all();
        $request->validate($this->validation('store'));
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title'], '-');
        $data['created_at'] = Carbon::now('Europe/Rome');
        $data['updated_at'] = $data['created_at'];
        if (!empty($data['img'])) {
            $data['img'] = Storage::disk('public')->put('images', $data['img']);
        } else {
            $data['img'] = $faker->imageUrl(640, 480);
        }

        $newPost = new Post;
        $newPost->fill($data);
        $stored = $newPost->save();

        // qui il comando $newPost = Post::create($data) non si può usare con $guarded = [] perché in $data c'è anche l'array dei tag e il metodo create non riesce a convertirlo in stringa.
        // Alternativa: dopo aver salvato $data = $request->all() faccio così: $tags = $data['tags']; unset($data['tags']); $newPost = Post::create($data); e poi faccio attach

        if (!empty($data['tags'])) {
            $newPost->tags()->attach($data['tags']);
        }

        if ($stored) {
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
        $request->validate($this->validation('update', $post));
        $data['slug'] = Str::slug($data['title']);
        $data['updated_at'] = Carbon::now('Europe/Rome');

        // sync tags
        if (!empty($data['tags'])) {
            $post->tags()->sync($data['tags']);
        } else {
            $post->tags()->detach();
        }

        if (!empty($data['img'])) {
            if (!empty($post->img)) {
                Storage::disk('public')->delete($post->img);
            }
            $data['img'] = Storage::disk('public')->put('images', $data['img']);
        }

        $updated = $post->update($data);

        // scrittura alternativa a redirect()->route()
        if ($updated) {
            return redirect(route('posts.index'))->with('status', ['success', 'Post updated successfully!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        $deleted = $post->delete();
        if ($deleted) {
            return redirect(route('posts.index'))->with('status', ['danger', "{$post->user->name}, you have deleted your post!"]);
        }
    }
}
