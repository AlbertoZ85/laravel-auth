@extends('layouts.app')
@section('title', 'Create post')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container p-3">
  <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    {{-- @method('POST') --}}

    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" class="form-control" placeholder="Inserisci il titolo">
    </div>
    <div class="form-group">
      <label for="img">Upload image</label>
      <input type="file" id="img" name="img" class="form-control-file" accept="image/*">
    </div>
    <div class="form-group">
      <label for="body">Body</label>
      <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
    </div>
    {{-- tag --}}
    <div class="form-group">
      @foreach ($tags as $tag)
        <label for="tag-{{$tag->name}}" class="ml-3">{{$tag->name}}</label>
        <input type="checkbox" name="tags[]" id="tag-{{$tag->name}}" value="{{$tag->id}}">
      @endforeach
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
@endsection