@extends('layouts.app')

@section('topnavbar')
<?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) { ?>
    @include('partials.adminnavbar')
<?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
<?php } ?>
@endsection

@section('title', 'ProjectUsers')

@section('content')

<div class="row m-0">
    <div class="col-sm-2">
        @include('partials.project_nav', ['project' => $project])
    </div>
    <div class="col-sm-8">
        <div class="d-flex gap-4 mt-4 container align-items-center text-uppercase">
            <h3><a class="text-decoration-none text-success" href="/project/{{$project->id}}">{{$project->title}}</a> / Members</h3>
        </div>
        <div class="col-md-12 px-4">
            <div class="card my-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="input-group rounded w-50">
                        <input type="search" name="search" id="mySearch" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon">
                            <i class="icon-magnifier"></i>
                        </button>
                    </div>
                    <?php if ($user_role === 'MANAGER') { ?>
                        <a href="/project/{{$project->id}}/members/invitation" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-plus"></i> Add Member</a>
                    <?php } ?>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                                <th scope="col">Username</th>
                                <th scope="col" style="width: 45%">Email</th>
                                <th scope="col" style="width: 20%">Role</th>
                                <?php if ($user_role === 'MANAGER') { ?>
                                    <th scope="col" style="width: 5%">Remove</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="table-members-body">
                            <?php
                            foreach ($project_users as $user) {
                                echo '<tr>';
                                echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/profile/' . $user->id . '"><i class="icon-rocket"></i></a></th>'; //TODO href
                                echo '<td>' . $user->username . '</td>';
                                echo '<td>' . $user->email . '</td>';
                                if ($user_role === 'MANAGER' && $user->user_role != 'MANAGER') {
                                    echo '<td>';
                                    echo '<form action="/project/' . $project->id . '/members/' . $user->id . '/update" method="POST">';
                                    echo csrf_field();
                                    echo '<div class="row m-0">';
                                    echo '<div class="col-md-8">';
                                    echo '<select name="role" class="form-select" aria-label="Disabled select example" required>';
                                    echo '<option value="GUEST" ' . (($user->user_role == 'GUEST') ? 'selected' : '') . '>GUEST</option>';
                                    echo '<option value="MEMBER" ' . (($user->user_role == 'MEMBER') ? 'selected' : '') . '>MEMBER</option>';
                                    echo '<option value="MANAGER" ' . (($user->user_role == 'MANAGER') ? 'selected' : '') . '>MANAGER</option>';
                                    echo '</select>';
                                    echo '</div>';
                                    echo '<div class="col-md-4">';
                                    echo '<button type="submit" class="btn btn-success"><i class="icon-arrow-right-circle"></i></button>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</form>';
                                    echo '</td>';
                                    echo '<td class="text-center">';
                                    echo '<form action="/project/' . $project->id . '/members/' . $user->id . '/remove" method="POST">';
                                    echo csrf_field();
                                    echo '<button type="submit" class="btn btn-danger"><i class="icon-close"></i></button>';
                                    echo '</form>';
                                    echo '</td>';
                                } else {
                                    echo '<td>' . $user->user_role . '</td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        const mysearch = document.getElementById("mySearch");
        mysearch.addEventListener("keyup", searchProjectMember);
        function searchProjectMember() {
            sendAjaxRequest('post', "/api/project/{{$project->id}}/members-search", {search: mysearch.value}, mySearchHandler);
        }
        function mySearchHandler() {
            let members = JSON.parse(this.responseText);
            console.log(members);

            let body = document.getElementById("table-members-body");

            let paginations = document.getElementsByClassName('pagination');
            for (let pag of paginations) {
                if (document.getElementById('myCardBody').contains(pag)) {
                    if (mysearch.value !== "") {
                        pag.style.display = 'none';
                    } else {
                        if (members.length > 10)
                            pag.style.display = 'flex';
                    }
                }
            }

            body.innerHTML = "";
            let count = 0;
            for(let member of members) {
                if (count === 10) break;
                count++;
                let tr = body.insertRow();
                let link = tr.insertCell();
                link.classList.add('text-center');
                link.innerHTML = '<a class="text-info my-rocket" href="/profile/' + member['id'] + '"><i class="icon-rocket"></i></a>';
                let title = tr.insertCell();
                title.innerHTML = member['username'];
                let description = tr.insertCell();
                description.innerHTML = member['email'];

                if ('{!! $user_role !!}' === 'MANAGER' && member['user_role'] !== 'MANAGER') {
                    let role = tr.insertCell();

                    let form1 = document.createElement("form");
                    form1.class = "notification-pop";
                    form1.setAttribute('method','POST');
                    form1.setAttribute('action','/project/' + {{$project->id}} + '/members/' + {{$user->id}} + '/update');

                    let row = document.createElement("div");
                    row.classList.add("row");
                    row.classList.add("m-0");

                    let div8 = document.createElement("div");
                    div8.classList.add("col-md-8");

                    let select = document.createElement("select");
                    select.name = "role";
                    select.classList.add("form-select")
                    select.required = true;

                    let options = ['GUEST','MEMBER','MANAGER'];

                    for (let o of options) {
                        let opt = document.createElement('option');
                        opt.value = o;
                        opt.innerHTML = o;
                        if (member['user_role'] === o) {
                            opt.selected = true;
                        }
                        select.appendChild(opt);
                    }

                    div8.appendChild(select);

                    let div4 = document.createElement("div");
                    div4.classList.add("col-md-4");

                    let button1 = document.createElement('button');
                    button1.type = 'submit';
                    button1.classList.add("btn");
                    button1.classList.add("btn-success");

                    let icon1 = document.createElement('i');
                    icon1.classList.add("icon-arrow-right-circle");
                    button1.appendChild(icon1);

                    div4.appendChild(button1);

                    row.appendChild(div8);
                    row.appendChild(div4);
                    form1.insertAdjacentHTML( 'beforeend', '{{ csrf_field() }}' );
                    form1.appendChild(row);

                    role.appendChild(form1);

                    let remove = tr.insertCell();

                    let form2 = document.createElement("form");
                    form2.class = "notification-pop";
                    form2.setAttribute('method','POST');
                    form2.setAttribute('action',"/project/" + {{$project->id}} + '/members/' + {{$user->id}} + '/remove');

                    let button2 = document.createElement('button');
                    button2.type = 'submit';
                    button2.classList.add("btn");
                    button2.classList.add("btn-danger");

                    let icon2 = document.createElement('i');
                    icon2.classList.add("icon-close");
                    button2.appendChild(icon2);

                    form2.insertAdjacentHTML( 'beforeend', '{{ csrf_field() }}' );
                    form2.appendChild(button2);

                    remove.appendChild(form2);
                } else {
                    let role = tr.insertCell();
                    role.innerHTML = member['user_role'];
                }
            }
        }
    </script>
@endsection
