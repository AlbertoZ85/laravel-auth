@extends('layouts.app')
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
  <form action="{{route('posts.store')}}" method="post">
    @csrf
    {{-- @method('POST') --}}

    <div class="form-group">
      <label for="title">Titolo</label>
      <input type="text" id="title" name="title" class="form-control" placeholder="Inserisci il titolo">
    </div>
    <div class="form-group">
      <label for="body">Body</label>
      <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
@endsection