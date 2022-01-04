<div class="my-container" style="height: 107px">
    <div class="navbar-align">
        <a href="{{ url('/') }}"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 200px;"/></a>
        <a class="btn btn-outline-success nav-item" href="#"> About us </a>
        <a class="btn btn-outline-success nav-item" href="#"> Support </a>
    @if (Auth::check())
            <a class="btn btn-outline-success nav-item" href="{{ url('/projects') }}"> Projects <a>
            <div id="notifications-btn" class="btn btn-outline-success nav-item my-dropdown">
                Notifications
                <div class="my-dropdown-content">
                    <?php
                        foreach ($notifications as $notification) {
                            if($notification['notification_type'] == 'INVITE') {
                                echo '<div  class="notification-pop">';
                                echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                echo '<a href="/invitation/'.$notification['id'].'" class=" btn-outline-success">'.$notification['notification_type'].'  '.'Notification'.'</a>';
                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
            <a id="profile-btn" class="btn btn-outline-success nav-item" href="{{ url('/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a>
            <a id="logout-btn" class="btn btn-outline-success nav-item" href="{{ url('/logout') }}"> Log Out </a>
        @else
            <a id="signup-btn" class="btn btn-outline-success nav-item" href="{{ url('/register') }}"> Sign Up </a>
            <a id="login-btn" class="btn btn-outline-success nav-item" href="{{ url('/login') }}"> Log In </a>
        @endif
    </div>
</div>
