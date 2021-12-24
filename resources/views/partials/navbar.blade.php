<div class="row" style="background: white">
    <div class="col-md-2">
        <h1><a href="{{ url('/homepage') }}">
                <img src="{{ asset('/images/planwiserlogo.png') }}" style="height: 60px; width: 100%"/>
            </a></h1>
    </div>
    <div class="col-md-10">
        <div class="container" style="top: 20%;">
            <a class="button" > About us </a>
            <a class="button" > Support </a>
            @if (Auth::check())
                <a class="button" > Projects </a>
            @endif
            @if (Auth::check())
                <a id="username-btn" class="button" href="{{ url('/profile/'.Auth::id()) }}"> {{ Auth::user()->username }} </a>
                <a id="logout-btn" class="button float-right" href="{{ url('/logout') }}"> Logout </a>
            @else
                <a id="signup-btn" class="button" href="{{ url('/register') }}"> Sign-up </a>
                <a id="login-btn" class="button" href="{{ url('/login') }}"> Login </a>
        </div>
    </div>
@endif
</div>
