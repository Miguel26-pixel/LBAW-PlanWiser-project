@extends('layouts.app')

@section('projects')

@section('content')
<form action='/projectsCreate' method="POST" enctype="multipart/form-data">
    @csrf

    <label for="title">Title</label>
    <input id="title" type="text" name="title" required>
    @if ($errors->has('title'))
      <span class="error">
          {{ $errors->first('title') }}
      </span>
    @endif

    <label for="description">Description</label>
    <input id="description" type="text" name="description"  required>
    @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
      </span>
    @endif

    <label for="public">Public</label>
    <input id="public" type="boolean" name="public" >
    @if ($errors->has('public'))
      <span class="error">
          {{ $errors->first('public') }}
      </span>
    @endif

    <label for="active">Active</label>
    <input id="active" type="boolean" name="active" >
    @if ($errors->has('active'))
      <span class="error">
          {{ $errors->first('active') }}
      </span>
    @endif

    <button type="submit">
      Create Project
    </button>
</form>
@endsection
