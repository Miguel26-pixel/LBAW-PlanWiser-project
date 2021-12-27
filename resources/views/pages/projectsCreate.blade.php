@extends('layouts.app')

@section('title', 'Create')

@section('content')
<div class="formbg-outer">
  <div class="formbg">
    <div class="formbg-inner" style="padding: 48px">
      <span style="padding-bottom: 15px">New Project</span>
      <form id="stripe-login" action="/projectsCreate" method="POST">
        @csrf
        <div class="field" style="padding-bottom: 24px">
          <label for="title">Title</label>
          <input id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>
        </div>
        @if ($errors->has('title'))
        <span class="error">
          {{ $errors->first('title') }}
        </span>
        @endif
        <div class="field" style="padding-bottom: 24px">
          <label for="description">Description</label>
          <input id="description" type="text" name="description" value="{{ old('description') }}" required autofocus>
        </div>
        @if ($errors->has('description'))
        <span class="error">
          {{ $errors->first('description') }}
        </span>
        @endif

        <div class="field" style="padding-bottom: 24px">
          <label for="public">Public</label>
          <select class="form-select" aria-label="Disabled select example" required>
              <option name="public" value="True">True</option>
              <option name="public" value="False">False</option>
          </select>
        </div>
        @if ($errors->has('public'))
        <span class="error">
          {{ $errors->first('public') }}
        </span>
        @endif

        <div class="field" style="padding-bottom: 24px">
          <input type="submit" name="submit" value="Create Project">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

