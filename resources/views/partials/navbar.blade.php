<div class="navbar navbar-expand-lg navbar-container" style="background-color: #2f4f4f">
    <div class="navbar-align w-100">
        <div style="display: flex; align-items: center; margin-right: 2vw">
            <a href="{{ url('/') }}" style="background-color: #ffffff; padding: 0.7em; border-radius: 50%; align-self:center">
                <img src="{{asset('/images/logo.png')}}" alt="logo" height="40">
            </a>
            <a href="{{ url('/') }}" style="color: white; font-size: 200%; font-weight: bold; margin-left: 0.4em">
                PlanWiser
            </a>
        </div>
        <div id="full-nav" class="w-100" style="display: flex; gap: 1em; align-items: center;">
            <ul class="navbar-nav mr-auto">
                <li class="navbar-nav mr-auto"><a class="nav-item" href="/home#aboutUs" style="width: max-content"> About Us </a></li>
                <li class="navbar-nav mr-auto"><a class="nav-item" href="/home#support"> Support </a></li>
                @if (Auth::check())
                    <li class="navbar-nav mr-auto"><a class="nav-item" href="{{ url('/projects') }}"> Projects </a></li>
                    <div class="nav-item my-dropdown">
                        Notifications
                        <div class="my-dropdown-content">
                            <div id="dropdown" style="padding:0 16px 0 16px; max-height: 300px; overflow: auto">
                                <?php
                                $count = 0;
                                foreach ($notifications as $notification) {
                                    if($notification->notification_type == 'INVITE') {
                                        $count++;
                                        echo '<div  class="notification-pop text-center">';
                                        echo '<a href="/invitation/'.$notification->id.'" class="my-1 w-100 btn btn-outline-secondary">You have been invited to the project '.$notification->project->title.'</a>';
                                        echo '</div>';
                                    } else if ($notification->notification_type == 'CHANGE_MANAGER') {
                                        $count++;
                                        echo '<form action="/notification/'.$notification->id.'/manager" method="POST" class="notification-pop text-center">';
                                        echo csrf_field();
                                        echo '<button type="submit" class="my-1 w-100 btn btn-outline-secondary">The project '.$notification->project->title.' has a new Manager</button>';
                                        echo '</form>';
                                    }
                                    else if ($notification->notification_type == 'COMPLETE_TASK') {
                                        $count++;
                                        echo '<form action="/notification/'.$notification->id.'/taskClosed" method="POST" class="notification-pop text-center">';
                                        echo csrf_field();
                                        echo '<button type="submit" class="my-1 w-100 btn btn-outline-secondary">The task '.$notification->task->name.' from project '.$notification->task->project->title.' had been closed</button>';
                                        echo '</form>';
                                    }
                                    else if ($notification->notification_type == 'ASSIGN') {
                                        $count++;
                                        echo '<form action="/notification/'.$notification->id.'/assign" method="POST" class="notification-pop text-center">';
                                        echo csrf_field();
                                        echo '<button type="submit" class="my-1 w-100 btn btn-outline-secondary">The Task '.$notification->task->name.' from project '.$notification->task->project->title.' had been assigned to you</button>';
                                        echo '</form>';
                                    }
                                }
                                ?>
                            </div>
                            <form id="clear-full" action="/notifications/{{\Illuminate\Support\Facades\Auth::id()}}/clear" method="POST" class="text-center">
                                @csrf
                                <button type="submit" class="my-1 w-50 btn btn-outline-danger">Clear All</button>
                            </form>
                            <div id="empty-full" class="my-1 text-secondary text-center">Empty</div>
                        </div>
                        <div id="notification-number-full" class="notification-number">
                            <div></div>
                        </div>
                    </div>
                @endif
            </ul>
            <div class="w-100">
                @if (Auth::check())
                    <ul class="navbar-nav" style="float: right">
                        <li class="navbar-nav"><a class="nav-item" href="{{ url('/profile/'.Auth::id()) }} " style="width: max-content"> {{ Auth::user()->username }} </a></li>
                        <li class="navbar-nav"><a class="nav-item" href="{{ url('/logout') }}" style="width: max-content"> Log Out </a></li>
                    </ul>
                @else
                    <ul class="navbar-nav" style="float: right">
                        <li class="navbar-nav mr-auto"><a id="profile-btn" class=" nav-item" href="{{ url('/register') }}" style="width: max-content"> Sign Up </a></li>
                        <li class="navbar-nav mr-auto"><a id="logout-btn" class="nav-item" href="{{ url('/login') }}" style="width: max-content"> Log In </a></li>
                    </ul>
                @endif
            </div>
        </div>
        <div id="compact-nav" class="w-100" style="display: flex; align-items: center;">
            <div class="w-100">
                @if (Auth::check())
                    <div class="my-dropdown" style="float: right; margin-left: 20px ">
                        <span class="btn btn-secondary"><i class="icon-bell"></i></span>
                        <div class="my-dropdown-content" style="top: auto; left: auto; right: 0 !important; width: 300px !important;">
                            <div id="dropdown" style="padding:0 16px 0 16px; max-height: 300px; overflow: auto">
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
                            </div>
                            <form id="clear-compact" action="/notifications/{{\Illuminate\Support\Facades\Auth::id()}}/clear" method="POST" class="text-center">
                                @csrf
                                <button type="submit" class="my-1 w-50 btn btn-outline-danger">Clear All</button>
                            </form>
                            <div id="empty-compact" class="my-1 text-secondary text-center">Empty</div>
                        </div>
                        <div id="notification-number-compact" class="notification-number" style="left: 78%">
                            <div></div>
                        </div>
                    </div>
                @endif
                <div class="navbar-dropdown" style="float: right;">
                    <span class="btn btn-secondary"><i class="icon-menu"></i></span>
                    <div class="navbar-dropdown-content">
                        <ul class="navbar-nav mr-auto fs-5">
                            <li><a class="dropdown-item" href="/home#aboutUs"> About Us </a></li>
                            <li><a class="dropdown-item" href="/home#support"> Support </a></li>
                            @if (Auth::check())
                                <li><a class="dropdown-item" href="{{ url('/projects') }}"> Projects </a></li>
                                <li><a class="dropdown-item" href="#"> Notifications </a></li>
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

<script>
    window.addEventListener('load', () => {

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('262b1acd7446e5873066', {
            cluster: 'eu',
        });

        var channel1 = pusher.subscribe('notifications-assignTasks');
        channel1.bind('event-assignTask-{{Auth::id()}}', function(data) {

            red_dot(1);

            let body = document.getElementById("dropdown");

            let div_pop = document.createElement("form");
            div_pop.class = "notification-pop";
            div_pop.setAttribute('method','POST');
            div_pop.setAttribute('action',"/notification/" + data.notification_id + "/assign");

            let button = document.createElement('button');
            button.type = 'submit';
            button.classList.add("btn");
            button.classList.add("btn-outline-secondary");
            button.classList.add("my-1");
            button.classList.add("w-100");
            button.innerText = data.message;
            button.style.color = "#198754";

            div_pop.insertAdjacentHTML( 'beforeend', '{{ csrf_field() }}' );
            div_pop.appendChild(button);
            body.prepend(div_pop);
        });

        var channel2 = pusher.subscribe('notifications-closedTasks');

        channel2.bind('event-closedTask-{{Auth::id()}}', function(data) {

            red_dot(1);

            let body = document.getElementById("dropdown");

            let div_pop = document.createElement("form");
            div_pop.class = "notification-pop";
            div_pop.setAttribute('method','POST');
            div_pop.setAttribute('action',"/notification/" + data.notification_id + "/taskClosed");

            let button = document.createElement('button');
            button.type = 'submit';
            button.classList.add("btn");
            button.classList.add("btn-outline-secondary");
            button.classList.add("my-1");
            button.classList.add("w-100");
            button.innerText = data.message;
            button.style.color = "#198754";

            div_pop.insertAdjacentHTML( 'beforeend', '{{ csrf_field() }}' );
            div_pop.appendChild(button);
            body.prepend(div_pop);
        });


        var channel3 = pusher.subscribe('notifications-invites');

        channel3.bind('event-invite-{{Auth::id()}}', function(data) {

            red_dot(1);

            let body = document.getElementById("dropdown");

            let div_pop = document.createElement("div");
            div_pop.class = "notification-pop";

            let button = document.createElement("a");
            button.setAttribute("href", "/invitation/" + data.notification_id);
            button.classList.add("btn");
            button.classList.add("btn-outline-secondary");
            button.classList.add("my-1");
            button.classList.add("w-100");
            button.innerText = data.message;
            button.style.color = "#198754";

            div_pop.appendChild(button);
            body.prepend(div_pop);
        });


        var channel4 = pusher.subscribe('notifications-changeManager');

        channel4.bind('event-changeManager-{{Auth::id()}}', function(data) {

            red_dot(1);

            let body = document.getElementById("dropdown");

            let div_pop = document.createElement("form");
            div_pop.class = "notification-pop";
            div_pop.setAttribute('method','POST');
            div_pop.setAttribute('action',"/notification/" + data.notification_id + "/manager");

            let button = document.createElement('button');
            button.type = 'submit';
            button.classList.add("btn");
            button.classList.add("btn-outline-secondary");
            button.classList.add("my-1");
            button.classList.add("w-100");
            button.innerText = data.message;
            button.style.color = "#198754";

            div_pop.insertAdjacentHTML( 'beforeend', '{{ csrf_field() }}' );
            div_pop.appendChild(button);
            body.prepend(div_pop);
        });


    });

    function red_dot(count) {
        if (count > 0) {
            let assign1 = document.getElementById('notification-number-full');
            assign1.style.visibility = 'visible';
            let assign2 = document.getElementById('notification-number-compact');
            assign2.style.visibility = 'visible';
            let empty_full = document.getElementById("empty-full");
            empty_full.style.display = 'none';
            let clear_full = document.getElementById("clear-full");
            clear_full.style.display = 'block';
            let empty_compact = document.getElementById("empty-compact");
            empty_compact.style.display = 'none';
            let clear_compact = document.getElementById("clear-compact");
            clear_compact.style.display = 'block';
        }
        else {
            let assign1 = document.getElementById('notification-number-full');
            assign1.style.visibility = 'hidden';
            let assign2 = document.getElementById('notification-number-compact');
            assign2.style.visibility = 'hidden';
            let empty_full = document.getElementById("empty-full");
            empty_full.style.display = 'block';
            let clear_full = document.getElementById("clear-full");
            clear_full.style.display = 'none';
            let empty_compact = document.getElementById("empty-compact");
            empty_compact.style.display = 'block';
            let clear_compact = document.getElementById("clear-compact");
            clear_compact.style.display = 'none';
        }
    }
</script>

<?php
 if (Auth::check()) {
    echo '<script type="text/javascript"> red_dot('.$count.') </script>';
 }
?>
