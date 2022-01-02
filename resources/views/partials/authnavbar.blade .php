<div class="navbar-align">
    <a href="{{ url('/homepage') }}"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 200px;"/></a>
    <a class="btn btn-outline-success nav-item"> About us </a>
    <a class="btn btn-outline-success nav-item"> Support </a>
    @if (Auth::check())
    <a class="btn btn-outline-success nav-item"> Projects <a>
@endif
@if (Auth::check())
    <a id="profile-btn" class="btn btn-outline-success nav-item" href="{{ url('/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a>
    <a id="logout-btn" class="btn btn-outline-success nav-item" href="{{ url('/logout') }}"> Log Out </a>
@else
    <a id="signup-btn" class="btn btn-outline-success nav-item" href="{{ url('/register') }}"> Sign Up </a>
    <a id="login-btn" class="btn btn-outline-success nav-item" href="{{ url('/login') }}"> Log In </a>
@endif
</div>
<hr/>
