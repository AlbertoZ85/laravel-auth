@extends('layouts.app')
@section('title', 'Post details')

@section('content')
<div class="container">
    <div class="row">
        <div class="offset-xl-2 col-xl-8 pt-3">
            <div class="card">
                <img src="{{Str::startsWith($post->img, 'http') ? $post->img : Storage::url($post->img)}}" class="card-img-top" alt="{{$post->title}}">
                <div class="card-body">
                    <h5 class="card-title">{{$post->title}}</h5>
                    <p class="card-text">{{$post->body}}</p>
                    <p class="card-text"><small class="text-muted">{{$post->user->name}}</small></p>
                    <p class="card-text text-right"><small class="text-muted">{{$post->created_at}}</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection