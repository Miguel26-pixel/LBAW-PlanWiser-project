@extends('layouts.app')

@section('topnavbar')
@include('partials.navbar')
@endsection

@section('content')
<div class="formbg-outer">
  <div class="formbg">
    <div class="formbg-inner" style="padding: 48px">
      <span style="padding-bottom: 15px">Sign Up</span>
      <form id="stripe-login" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field" style="padding-bottom: 24px">
          <label for="fullname">Full Name</label>
          <input id="fullname" type="text" name="fullname" value="{{ old('fullname') }}" required autofocus>
        </div>
        @if ($errors->has('fullname'))
        <span class="error">
          {{ $errors->first('fullname') }}
        </span>
        @endif
        <div class="field" style="padding-bottom: 24px">
          <label for="username">Username</label>
          <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
        </div>
        @if ($errors->has('username'))
        <span class="error">
          {{ $errors->first('username') }}
        </span>
        @endif

        @if ($errors->has('password'))
        <span class="error">
          {{ $errors->first('password') }}
        </span>
        @endif
        <div class="field" style="padding-bottom: 24px">
          <label for="email">E-Mail Address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
        @endif

        <div class="field" style="padding-bottom: 24px">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" required>
        </div>
        @if ($errors->has('password'))
        <span class="error">
          {{ $errors->first('password') }}
        </span>
        @endif

        <div class="field" style="padding-bottom: 24px">
          <label for="password-confirm">Confirm Password</label>
          <input id="password-confirm" type="password" name="password_confirmation" required>
        </div>

        <div class="field" style="padding-bottom: 24px">
          <input type="submit" name="submit" value="Register">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
