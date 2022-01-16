<div class="navbar navbar-expand-lg navbar-container" style="background-color: #2f4f4f">
    <div class="navbar-align">
        <div style="display: flex; gap: 1em; align-items: center; width: 57em; justify-content: flex-start; padding-right: 80vw">
            <div style="display: flex; align-items: center; margin-right: 2vw">
                <a href="{{ url('/') }}" style="background-color: #ffffff; padding: 0.7em; border-radius: 50%; align-self:center">
                    <img src="{{asset('/images/logo.png')}}" height="40">
                </a>
                <a href="{{ url('/') }}" style="color: white; font-size: 200%; font-weight: bold; margin-left: 0.4em">
                    PlanWiser
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-bars" style="color: white"></i>
            </button>
            <div class="collapse navbar-collapse navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="navbar-nav mr-auto"><a class="nav-item" href="/home#aboutUs" style="width: max-content"> About Us </a></li>
                    <li class="navbar-nav mr-auto"><a class="nav-item" href="/home#support"> Support </a></li>
                    @if (Auth::check())
                        <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('/projects') }}"> Projects </a></li>
                        <div class="nav-item my-dropdown">
                            Notifications
                            <div class="my-dropdown-content">
                                <?php
                                $count = 0;
                                foreach ($notifications as $notification) {
                                    if ($notification['notification_type'] == 'INVITE') {
                                        $count++;
                                        echo '<div  class="notification-pop">';
                                        echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                        echo '<a href="/invitation/' . $notification['id'] . '" class=" btn-outline-success">Invite Notification' . '</a>';
                                        echo '</div>';
                                    } else if ($notification['notification_type'] == 'CHANGE_MANAGER') {
                                        $count++;
                                        echo '<form action="/notification/' . $notification['id'] . '/manager" method="POST" class="notification-pop">';
                                        echo csrf_field();
                                        echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                        echo '<button type="submit" class="btn-outline-success">Manager as Changed' . '</button>';
                                        echo '</form>';
                                    } else if ($notification['notification_type'] == 'COMPLETE_TASK') {
                                        $count++;
                                        echo '<form action="/notification/' . $notification['id'] . '/taskClosed" method="POST" class="notification-pop">';
                                        echo csrf_field();
                                        echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                        echo '<button type="submit" class="btn-outline-success">Task has been closed.' . '</button>';
                                        echo '</form>';
                                    } else if ($notification['notification_type'] == 'ASSIGN') {
                                        $count++;
                                        echo '<form action="/notification/' . $notification['id'] . '/assign" method="POST" class="notification-pop">';
                                        echo csrf_field();
                                        echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                        echo '<button type="submit" class="btn-outline-success">Task has been assigned.' . '</button>';
                                        echo '</form>';
                                    }
                                }
                                if ($count == 0) {
                                    echo '<div class="text-secondary">Empty</div>';
                                }
                                ?>
                            </div>
                        </div>
                    @endif
                </ul>
            </div>
        </div>
        @if (Auth::check())
            <div class="collapse navbar-collapse navbarSupportedContent" style="justify-content: flex-end;">
                <ul class="navbar-nav">
                    <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a></li>
                    <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('/logout') }}"> Log Out </a></li>
                </ul>
            </div>
        @else
            <div class="collapse navbar-collapse navbarSupportedContent" style="justify-content: flex-end;">
                <ul class="navbar-nav">
                    <li class="navbar-nav mr-auto"><a id="profile-btn" class=" nav-item" href="{{ url('/register') }}" style="width: max-content"> Sign Up </a></li>
                    <li class="navbar-nav mr-auto"><a id="logout-btn" class="nav-item" href="{{ url('/login') }}" style="width: max-content"> Log In </a></li>
                </ul>
            </div>
        @endif
    </div>
</div>
