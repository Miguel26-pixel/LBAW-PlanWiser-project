<div class="my-container" style="height: 107px">
    <div class="navbar-align">
        <a href="{{ url('/') }}"><img src="{{ asset('/images/planwiserlogo.png') }}" style="width: 200px;"/></a>
        <a class="btn btn-outline-success nav-item" href="/home#aboutUs"> About us </a>
        <a class="btn btn-outline-success nav-item" href="/home#support"> Support </a>
    @if (Auth::check())
            <a class="btn btn-outline-success nav-item" href="{{ url('/projects') }}"> Projects </a>
            <div class="btn btn-outline-success nav-item my-dropdown mt-2">
                Notifications
                <div id="dropdown" class="my-dropdown-content">
                    <?php
                        $count = 0;
                        foreach ($notifications as $notification) {
                            if($notification['notification_type'] == 'INVITE') {
                                $count++;
                                echo '<div  class="notification-pop">';
                                    echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                    echo '<a href="/invitation/'.$notification['id'].'" class=" btn-outline-success">Invite Notification'.'</a>';
                                echo '</div>';
                            } else if ($notification['notification_type'] == 'CHANGE_MANAGER') {
                                $count++;
                                echo '<form action="/notification/'.$notification['id'].'/manager" method="POST" class="notification-pop">';
                                    echo csrf_field();
                                    echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                    echo '<button type="submit" class="btn-outline-success">Manager as Changed'.'</button>';
                                echo '</form>';
                            }
                            else if ($notification['notification_type'] == 'COMPLETE_TASK') {
                                $count++;
                                echo '<form action="/notification/'.$notification['id'].'/taskClosed" method="POST" class="notification-pop">';
                                    echo csrf_field();
                                    echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                    echo '<button type="submit" class="btn-outline-success">Task has been closed.'.'</button>';
                                echo '</form>';
                            }
                            else if ($notification['notification_type'] == 'ASSIGN') {
                                $count++;
                                echo '<form id="assign" action="/notification/'.$notification['id'].'/assign" method="POST" class="notification-pop">';
                                    echo csrf_field();
                                    echo '<div scope="row"><a class="text-info my-rocket"></a></div>';
                                    echo '<button type="submit" class="btn-outline-success">Task has been assigned.'.'</button>';
                                echo '</form>';
                            }
                        }
                        if ($count == 0) {
                            echo '<div class="text-secondary">Empty</div>';
                        }
                    ?>
                </div>
                <div class="notification-number">
                    <div></div>
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

<script>
    window.addEventListener('load', () => {

        // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('262b1acd7446e5873066', {
        cluster: 'eu'
    });

    var channel = pusher.subscribe('notifications-assignTasks');
    channel.bind('event-assignTasks-{{Auth::id()}}', function(data) {
        console.log("ola");
        let assign = document.querySelector('.notification-number');
        assign.style.visibility = 'visible';

        // let body = document.getElementById("assign");

        // let button = document.createElement("button");
        // button.setAttribute("type", "submit");
        // button.class = "btn-outline-success";
        // button.innerText = "ola";

        // form.appendChild(button);
        // body.appendChild(form);
        console.log(data);
    });

    });
  </script>