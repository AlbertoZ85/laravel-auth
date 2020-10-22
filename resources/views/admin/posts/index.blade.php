@extends('layouts.app')
@section('title', 'Your posts')

@section('content')
<div class="container p-3">
    
    @if (session('status'))
    <div class="alert alert-{{session('status')[0]}}">
        <p>{{session('status')[1]}}</p>
    </div>
    @endif

    <table class="table table-light table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <th scope="row">{{$post->id}}</th>
                    <td>{{$post->title}}</td>
                    <td><a href="{{route('posts.edit', $post->id)}}" class="btn btn-primary">Edit</a></td>
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