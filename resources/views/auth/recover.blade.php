@extends('layouts.app')

@section('topnavbar')
    @include('partials.navbar')
@endsection

@section('content')
    <div class="formbg-outer">
        <div class="formbg">
            <div class="formbg-inner" style="padding: 48px">
                <span style="padding-bottom: 15px">Log In to your account</span>
                <form id="stripe-login" method="POST" action="/api/recover">
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
                        <input type="submit" name="submit" value="Recover Password">
                    </div>
                </form>
            </div>
        </div>
@endsection
