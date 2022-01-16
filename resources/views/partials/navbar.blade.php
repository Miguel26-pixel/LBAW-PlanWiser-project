<div class="navbar navbar-expand-lg navbar-container" style="background-color: #2f4f4f">
    <div class="navbar-align">
        <div style="display: flex; gap: 1em; align-items: center; width: 57em; justify-content: flex-start; padding-right: 80vw">
            <div style="display: flex; align-items: center; margin-right: 2vw">
                <a href="{{ url('/') }}" style="background-color: #ffffff; padding: 0.7em; border-radius: 50%; align-self:center">
                    <img src="{{asset('/images/logo.png')}}" alt="logo" height="40">
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
                            <div id="dropdown" class="my-dropdown-content">
                                <?php
                                $count = 0;
                                foreach ($notifications as $notification) {
                                    if($notification->notification_type == 'INVITE') {
                                        $count++;
                                        echo '<div  class="notification-pop text-center">';
                                        echo '<a href="/invitation/'.$notification->id.'" class="my-1 w-100 btn btn-outline-success">You have been invited to the project '.$notification->project->title.'</a>';
                                        echo '</div>';
                                    } else if ($notification->notification_type == 'CHANGE_MANAGER') {
                                        $count++;
                                        echo '<form action="/notification/'.$notification->id.'/manager" method="POST" class="notification-pop text-center">';
                                        echo csrf_field();
                                        echo '<button type="submit" class="my-1 w-100 btn btn-outline-success">The project '.$notification->project->title.' has a new Manager</button>';
                                        echo '</form>';
                                    }
                                    else if ($notification->notification_type == 'COMPLETE_TASK') {
                                        $count++;
                                        echo '<form action="/notification/'.$notification->id.'/taskClosed" method="POST" class="notification-pop text-center">';
                                        echo csrf_field();
                                        echo '<button type="submit" class="my-1 w-100 btn btn-outline-success">The task '.$notification->task->name.' from project '.$notification->task->project->title.' had been closed</button>';
                                        echo '</form>';
                                    }
                                    else if ($notification->notification_type == 'ASSIGN') {
                                        $count++;
                                        echo '<form action="/notification/'.$notification->id.'/assign" method="POST" class="notification-pop text-center">';
                                        echo csrf_field();
                                        echo '<button type="submit" class="my-1 w-100 btn btn-outline-success">The Task '.$notification->task->name.' from project '.$notification->task->project->title.' had been assigned to you</button>';
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
                    @endif
                </ul>
            </div>
        </div>
        @if (Auth::check())
            <div class="collapse navbar-collapse navbarSupportedContent" style="justify-content: flex-end;">
                <ul class="navbar-nav">
                    <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('/profile/'.Auth::id()) }} "> {{ Auth::user()->username }} </a></li>
                    <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('/logout') }}">Log Out</a></li>
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
            button.classList.add("btn");
            button.classList.add("btn-outline-success");
            button.classList.add("my-1");
            button.classList.add("w-100");
            button.innerText = data.message;
            button.style.color = "#198754";

            let csrf = document.createElement('meta');
            csrf.setAttribute('name','csrf-token');
            csrf.setAttribute('content', '{{ csrf_field() }}');

            div_pop.appendChild(csrf);
            div_pop.appendChild(button);
            body.prepend(div_pop);
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
            button.classList.add("btn");
            button.classList.add("btn-outline-success");
            button.classList.add("my-1");
            button.classList.add("w-100");
            button.innerText = data.message;
            button.style.color = "#198754";

            let csrf = document.createElement('meta');
            csrf.setAttribute('name','csrf-token');
            csrf.setAttribute('content', '{{ csrf_field() }}');

            div_pop.appendChild(csrf);
            div_pop.appendChild(button);
            body.prepend(div_pop);
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
            button.classList.add("btn");
            button.classList.add("btn-outline-success");
            button.classList.add("my-1");
            button.classList.add("w-100");
            button.innerText = data.message;
            button.style.color = "#198754";

            div_pop.appendChild(button);
            body.prepend(div_pop);
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
            button.classList.add("btn");
            button.classList.add("btn-outline-success");
            button.classList.add("my-1");
            button.classList.add("w-100");
            button.innerText = data.message;
            button.style.color = "#198754";

            let csrf = document.createElement('meta');
            csrf.setAttribute('name','csrf-token');
            csrf.setAttribute('content', '{{ csrf_field() }}');

            div_pop.appendChild(csrf);
            div_pop.appendChild(button);
            body.prepend(div_pop);
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
