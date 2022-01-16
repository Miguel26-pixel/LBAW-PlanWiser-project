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
                            if($notification->notification_type == 'INVITE') {
                                $count++;
                                echo '<div  class="notification-pop">';
                                    echo '<a href="/invitation/'.$notification->id.'" class=" btn-outline-success">You have been invited to the project '.$notification->project->title.'</a>';
                                echo '</div>';
                            } else if ($notification->notification_type == 'CHANGE_MANAGER') {
                                $count++;
                                echo '<form action="/notification/'.$notification->id.'/manager" method="POST" class="notification-pop">';
                                    echo csrf_field();
                                    echo '<button type="submit" class="btn-outline-success">'.$notification->project->title.' has a new Manager</button>';
                                echo '</form>';
                            }
                            else if ($notification->notification_type == 'COMPLETE_TASK') {
                                $count++;
                                echo '<form id="assign" action="/notification/'.$notification->id.'/taskClosed" method="POST" class="notification-pop">';
                                    echo csrf_field();
                                    echo '<button type="submit" class="btn-outline-success">. Task '.$notification->task->name.' from project '.$notification->task->project->title.' had been closed'.'</button>';
                                echo '</form>';
                            }
                            else if ($notification->notification_type == 'ASSIGN') {
                                $count++;
                                echo '<form id="assign" action="/notification/'.$notification->id.'/assign" method="POST" class="notification-pop">';
                                    echo csrf_field();
                                    echo '<button type="submit" class="btn-outline-success">Task '.$notification->task->name.' from project '.$notification->task->project->title.' had been assigned to you'.'</button>';
                                echo '</form>';
                            }
                        }
                    ?>
                <div id="empty" class="text-secondary">Empty</div>
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
            cluster: 'eu',
        });

        var channel1 = pusher.subscribe('notifications-assignTasks');
        console.log('event-assignTask-{{Auth::id()}}');
        channel1.bind('event-assignTask-{{Auth::id()}}', function(data) {

            let assign = document.querySelector('.notification-number');
            assign.style.visibility = 'visible';

            let empty = document.getElementById("empty");
            empty.style.visibility = 'hidden';

            let body = document.getElementById("dropdown");

            let div_pop = document.createElement("form");
            div_pop.class = "notification-pop";
            div_pop.setAttribute('method','POST');
            div_pop.setAttribute('action',"/notification/" + data.notification_id + "/assign");

            let button = document.createElement('button');
            button.type = 'submit';
            button.class = "btn-outline-success";
            button.innerText = data.message;
            button.style.color = "#198754";

            let csrf = document.createElement('meta');
            csrf.setAttribute('name','csrf-token');
            csrf.setAttribute('content', '{{ csrf_field() }}');

            div_pop.appendChild(csrf);
            div_pop.appendChild(button);
            body.appendChild(div_pop);
        });

        var channel2 = pusher.subscribe('notifications-closedTasks');

        channel2.bind('event-closedTask-{{Auth::id()}}', function(data) {

            let assign = document.querySelector('.notification-number');
            assign.style.visibility = 'visible';

            let empty = document.getElementById("empty");
            empty.style.visibility = 'hidden';

            let body = document.getElementById("dropdown");

            let div_pop = document.createElement("form");
            div_pop.class = "notification-pop";
            div_pop.setAttribute('method','POST');
            div_pop.setAttribute('action',"/notification/" + data.notification_id + "/taskClosed");

            let button = document.createElement('button');
            button.type = 'submit';
            button.class = "btn-outline-success";
            button.innerText = data.message;
            button.style.color = "#198754";

            let csrf = document.createElement('meta');
            csrf.setAttribute('name','csrf-token');
            csrf.setAttribute('content', '{{ csrf_field() }}');

            div_pop.appendChild(csrf);
            div_pop.appendChild(button);
            body.appendChild(div_pop);
        });


        var channel3 = pusher.subscribe('notifications-invites');

        channel3.bind('event-invite-{{Auth::id()}}', function(data) {

            let assign = document.querySelector('.notification-number');
            assign.style.visibility = 'visible';

            let empty = document.getElementById("empty");
            empty.style.visibility = 'hidden';

            let body = document.getElementById("dropdown");

            let div_pop = document.createElement("div");
            div_pop.class = "notification-pop";

            let button = document.createElement("a");
            button.setAttribute("href", "/invitation/" + data.notification_id);
            button.class = "btn-outline-success";
            button.innerText = data.message;
            button.style.color = "#198754";

            div_pop.appendChild(button);
            body.appendChild(div_pop);
        });


        var channel4 = pusher.subscribe('notifications-changeManager');

        channel4.bind('event-changeManager-{{Auth::id()}}', function(data) {

            let assign = document.querySelector('.notification-number');
            assign.style.visibility = 'visible';

            let empty = document.getElementById("empty");
            empty.style.visibility = 'hidden';

            let body = document.getElementById("dropdown");

            let div_pop = document.createElement("form");
            div_pop.class = "notification-pop";
            div_pop.setAttribute('method','POST');
            div_pop.setAttribute('action',"/notification/" + data.notification_id + "/manager");

            let button = document.createElement('button');
            button.type = 'submit';
            button.class = "btn-outline-success";
            button.innerText = data.message;
            button.style.color = "#198754";

            let csrf = document.createElement('meta');
            csrf.setAttribute('name','csrf-token');
            csrf.setAttribute('content', '{{ csrf_field() }}');

            div_pop.appendChild(csrf);
            div_pop.appendChild(button);
            body.appendChild(div_pop);
        });


    });

    function red_dot(count) {
        if (count > 0) {
            let assign = document.querySelector('.notification-number');
            assign.style.visibility = 'visible';
            let empty = document.getElementById("empty");
            empty.style.display = 'none';
        }
        else {
            let assign = document.querySelector('.notification-number');
            assign.style.visibility = 'hidden';
            let empty = document.getElementById("empty");
            empty.style.display = 'block';
        }
    }
</script>

<?php
 if (Auth::check()) {
    echo '<script type="text/javascript"> red_dot('.$count.') </script>';
 }
?>
