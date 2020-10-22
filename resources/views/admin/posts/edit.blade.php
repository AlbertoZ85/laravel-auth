@extends('layouts.app')
@section('title', 'Edit post')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          <p>{{$error}}</p>
        @endforeach
    </div>
@endif

<div class="container p-3">
  <form action="{{route('posts.update', $post->id)}}" method="post">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="title">Titolo</label>
      <input type="text" id="title" name="title" class="form-control" value="{{$post->title}}">
    </div>
    <div class="form-group">
      <label for="body">Body</label>
      <textarea class="form-control" name="body" id="body" cols="30" rows="10">{{$post->body}}</textarea>
    </div>
    <div class="form-group">
      @foreach ($tags as $tag)
        <label for="tag-{{$tag->name}}" class="ml-3">{{$tag->name}}</label>
        <input type="checkbox" name="tags[]" id="tag-{{$tag->name}}" value="{{$tag->id}}" {{$post->tags->contains($tag->id) ? 'checked' : ''}}>
      @endforeach
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
</div>
@endsection