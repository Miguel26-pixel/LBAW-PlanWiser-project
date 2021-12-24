<div class="navbar-align">
    <a href="{{ url('/homepage') }}"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 240px;"/></a>
    <a class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;"> About us </a>
    <a class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;"> Support </a>
    @if (Auth::check())
    <a class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;"> Projects <a>
@endif
@if (Auth::check())
    <a class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a>
    <a class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/logout') }}"> Logout </a>
@else
    <a id="signup-btn" class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/register') }}"> Sign-up </a>
    <a id="login-btn" class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/login') }}"> Login </a>
@endif
</div>
