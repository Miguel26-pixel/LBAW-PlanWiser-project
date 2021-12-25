@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('projectsCreate') }}">
    {{ csrf_field() }}

    <label for="title">Title</label>
    <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>
    @if ($errors->has('title'))
      <span class="error">
          {{ $errors->first('title') }}
      </span>
    @endif

    <label for="description">Description</label>
    <input id="description" type="text" name="description" value="{{ old('description') }}" required autofocus>
    @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
      </span>
    @endif

    <label for="public">Public</label>
    <input id="public" type="text" name="public" value="{{ old('public') }}" required>
    @if ($errors->has('public'))
      <span class="error">
          {{ $errors->first('public') }}
      </span>
    @endif

    <label for="active">Active</label>
    <input id="active" type="text" name="active" required>
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
