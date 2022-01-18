<div class="navbar navbar-expand-lg navbar-container" style="background-color: #2f4f4f">
    <div class="navbar-align w-100">
        <div style="display: flex; align-items: center; margin-right: 2vw">
            <a href="{{ url('/') }}" style="background-color: #ffffff; padding: 0.7em; border-radius: 50%; align-self:center">
                <img src="{{asset('/images/logo.png')}}" height="40">
            </a>
            <a href="{{ url('/') }}" style="color: white; font-size: 200%; font-weight: bold; margin-left: 0.4em">
                PlanWiser
            </a>
        </div>
        <div id="full-nav" class="w-100" style="display: flex; gap: 1em; align-items: center;">
            <ul class="navbar-nav mr-auto">
                <li class="navbar-nav mr-auto"><a class="nav-item" href="/admin"> Dashboard </a></li>
                <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('admin/manageUsers') }}">Users</a></li>
                <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('admin/reports') }}">Reports</a></li>
                <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('admin/projects') }}"> Projects </a></li>
            </ul>
            <div class="w-100">
                @if (Auth::check())
                    <ul class="navbar-nav" style="float: right">
                        <li class="navbar-nav"><a class="nav-item" href="{{ url('/profile/'.Auth::id()) }} " style="width: max-content"> {{ Auth::user()->username }} </a></li>
                        <li class="navbar-nav"><a class="nav-item" href="{{ url('/logout') }}" style="width: max-content"> Log Out </a></li>
                    </ul>
                @else
                    <ul class="navbar-nav" style="float: right">
                        <li class="navbar-nav"><a class=" nav-item" href="{{ url('/register') }}" style="width: max-content"> Sign Up </a></li>
                        <li class="navbar-nav"><a class="nav-item" href="{{ url('/login') }}" style="width: max-content"> Log In </a></li>
                    </ul>
                @endif
            </div>
        </div>
        <div id="compact-nav" class="w-100" style="display: flex; align-items: center;">
            <div class="w-100">
                <div class="navbar-dropdown" style="float: right;">
                    <span class="btn btn-secondary"><i class="icon-menu"></i></span>
                    <div class="navbar-dropdown-content">
                        <ul class="navbar-nav mr-auto fs-5">
                            <li><a class="dropdown-item" href="/admin"> Dashboard </a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/manageUsers') }}">Users</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/reports') }}">Reports</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/projects') }}"> Projects </a></li>
                            @if (Auth::check())
                                <li><a class="dropdown-item" href="{{ url('/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a></li>
                                <li><a class="dropdown-item" href="{{ url('/logout') }}"> Log Out </a></li>
                            @else
                                <li><a class="dropdown-item" href="{{ url('/register') }}"> Sign Up </a></li>
                                <li><a class="dropdown-item" href="{{ url('/login') }}"> Log In </a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
