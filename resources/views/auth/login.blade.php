@extends('layouts.app')

@section('topnavbar')
@include('partials.navbar')
@endsection

@section('content')
<div class="formbg-outer">
    <div class="formbg">
        <div class="formbg-inner" style="padding: 48px">
            <span style="padding-bottom: 15px">Log In to your account</span>
            <form id="stripe-login" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="field" style="padding-bottom: 24px" value="{{ old('email') }}" required autofocus>
                    <label for="email">Email</label>
                    <input type="email" name="email">
                </div>
                @if ($errors->has('email'))
                <div class="field">
                    <span class="error">
                        {{ $errors->first('email') }}
                    </span>
                </div>
                @endif
                <div class="field" style="padding-bottom: 24px">
                    <div class="grid--50-50">
                        <label for="password">Password</label>
                        <div class="reset-pass">
                            <a href="#">Forgot your password?</a>
                        </div>
                    </div>
                    <input type="password" name="password">
                </div>
                @if ($errors->has('password'))
                <span class="error">
                    {{ $errors->first('password') }}
                </span>
                @endif
                <div class="field field-checkbox flex align-center" style="padding-bottom: 24px">
                    <label for="checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
                <div class="field" style="padding-bottom: 24px">
                    <input type="submit" name="submit" value="Login">
                </div>
            </form>
        </div>
    </div>
    @endsection
