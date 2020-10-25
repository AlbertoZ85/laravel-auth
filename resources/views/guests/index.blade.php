@extends('layouts.app')
@section('title', 'Posts list')

@section('content')
<div class="container">
    <div class="card-group">
        <div class="row">

        @foreach ($posts as $post)
            <div class="offset-md-1 col-md-10 offset-lg-0 col-lg-6 col-xl-4 pt-3">
                <div class="card">
                    <img src="{{Str::startsWith($post->img, 'http') ? $post->img : Storage::url($post->img)}}" class="card-img-top img-az" alt="{{$post->title}}">
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{{Str::substr($post->body, 0, 150). "..."}}</p>
                        <p class="card-text"><small class="text-muted">{{$post->user->name}}</small></p>
                        <a href="{{route('guest.posts.show', $post->slug)}}" class="btn btn-primary">Details</a>
                    </div>
                </div>
            </div>
        @endforeach

        </div>
    </div>
</div>
@endsection
