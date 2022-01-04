<div class="my-container" style="height: 107px">
    <div class="navbar-align">
        <a href="{{ url('/') }}"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 200px;"/></a>
        <a class="btn btn-outline-success nav-item" href="#aboutUs"> About us </a>
        <a class="btn btn-outline-success nav-item" href="#support"> Support </a>
        @if (Auth::check())
            <a class="btn btn-outline-success nav-item" href="{{ url('/projects') }}"> Projects <a>
                    @endif
                    @if (Auth::check())
                    <div id="notifications-btn" class="btn btn-outline-success nav-item my-dropdown">
                        Notifications
                        <div class="my-dropdown-content">
                            <?php
                            //dd($notifications);
                            foreach ($notifications as $notification) {
                                //dd($notification);
                                if($notification['notification_type'] == 'INVITE') {
                                    echo '<div  class="notification-pop">';
                                    echo '<th scope="row"><a class="text-info my-rocket"></a></th>';
                                    echo '<button class="notification-btn">'.$notification['notification_type'].'</button>';
                                    //echo '<td>'.$notification['description'].'</td>';
                                    //echo '<td>'.$notification['due_date'].'</td>';
                                    //echo '<td>'.$notification['username'].'</td>';
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
