<div class="navbar-align">
    <a href="{{ url('/') }}"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 240px;"/></a>
    <a class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;"> About us </a>
    <a class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;"> Support </a>
    @if (Auth::check())
    <a class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/projects') }}"> Projects <a>
@endif
@if (Auth::check())
    <div id="notifications-btn" style="width:100%; border-style:hidden; margin-top: 5%;" class="btn btn-outline-success my-dropdown">
        <span>Notifications <i class="icon-bell"></i></span>
        <div class="my-dropdown-content">
            <p>Hello World!</p>
        </div>
    </div>
    <a id="profile-btn" class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a>
    <a id="logout-btn" class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/logout') }}"> Logout </a>
@else
    <a id="signup-btn" class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/register') }}"> Sign-up </a>
    <a id="login-btn" class="btn btn-outline-success" style="border-style:hidden; margin-top: 5%;" href="{{ url('/login') }}"> Login </a>
@endif
</div>
