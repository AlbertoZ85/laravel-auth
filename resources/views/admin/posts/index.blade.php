@extends('layouts.app')
@section('title', 'My posts')

@section('content')
<div class="container p-3">
    
    @if (session('status'))
    <div class="alert alert-{{session('status')[0]}}">
        <p>{{session('status')[1]}}</p>
    </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="bg-primary">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Preview</th>
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <th scope="row">{{$post->id}}</th>
                    <th scope="row">{{$post->title}}</td>
                    <td>{{Str::substr($post->body, 0, 100). "..."}}</td>
                    <td><a href="{{route('guest.posts.show', $post->slug)}}" class="btn btn-primary">Show</a></td>
                    <td><a href="{{route('posts.edit', $post->id)}}" class="btn btn-success">Edit</a></td>
                    <td>
                        <form action="{{route('posts.destroy', $post->id)}}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection