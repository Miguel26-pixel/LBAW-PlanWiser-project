<div class="my-container" style="height: 107px">
    <div class="navbar-align">
        <a href="{{ url('/') }}"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 200px;" /></a>
        <a class="btn btn-outline-success nav-item" href="{{ url('admin/manageUsers') }}">Manage Users</a>
        <a class="btn btn-outline-success nav-item" href="{{ url('admin/reportsInformations') }}">Reports</a>
        <a class="btn btn-outline-success nav-item" href="{{ url('admin/projects') }}"> Projects <a>

        <a id="profile-btn" class="btn btn-outline-success nav-item" href="{{ url('admin/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a>
        <a id="logout-btn" class="btn btn-outline-success nav-item" href="{{ url('/logout') }}"> Log Out </a>
    </div>
</div>