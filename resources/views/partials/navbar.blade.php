<div class="navbar-align">
    <a href="{{ url('/') }}"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 200px;"/></a>
    <a class="btn btn-outline-success nav-item"> About us </a>
    <a class="btn btn-outline-success nav-item"> Support </a>
    @if (Auth::check())
    <a class="btn btn-outline-success nav-item" href="{{ url('/projects') }}"> Projects <a>
@endif
@if (Auth::check())
    <div id="notifications-btn" class="btn btn-outline-success nav-item my-dropdown">
        Notifications
        <div class="my-dropdown-content">
            <p>Hello World!</p>
        </div>
    </div>
    <a id="profile-btn" class="btn btn-outline-success nav-item" href="{{ url('/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a>
    <a id="logout-btn" class="btn btn-outline-success nav-item" href="{{ url('/logout') }}"> Logout </a>
@else
    <a id="signup-btn" class="btn btn-outline-success nav-item" href="{{ url('/register') }}"> Sign-up </a>
    <a id="login-btn" class="btn btn-outline-success nav-item" href="{{ url('/login') }}"> Login </a>
@endif
</div>
<hr/>
