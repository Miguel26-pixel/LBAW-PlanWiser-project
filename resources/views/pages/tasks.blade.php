@extends('layouts.app')

@section('title', 'Task')

@section('topnavbar')
<?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) { ?>
    @include('partials.adminnavbar')
<?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
<?php } ?>
@endsection

@section('content')

<div class="row m-0">
    <div class="col-sm-2">
        @include('partials.project_nav', ['project' => $project])
    </div>
    <div class="col-sm-8">
        <div class="d-flex gap-4 mt-5 container align-items-center text-uppercase">
            <h3><a class="text-decoration-none text-success" href="/project/{{$project->id}}">{{$project->title}}</a> / Tasks</h3>
        </div>
        <div class="col-md-12 px-4 my-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="input-group rounded w-50">
                        <input type="search" name="search" id="mySearch" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon" disabled>
                            <i class="icon-magnifier"></i>
                        </button>
                    </div>
                    <?php if ($user_role === 'MANAGER') { ?>
                        <a href="tasksCreate" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-plus"></i> New Task</a>
                    <?php } ?>
                </div>

                <div id="publicCardBody" class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Due date</th>
                                <th scope="col">Assignee</th>
                                <th scope="col">Stage</th>
                            </tr>
                        </thead>
                        <tbody id="table-tasks-body">
                            <?php
                            foreach ($tasks as $task) {
                                echo '<tr>';
                                echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/project/' . $project['id'] . '/task/' . $task['id'] . '"><i class="icon-rocket"></i></a></th>';
                                echo '<td>' . $task['name'] . '</td>';
                                echo '<td>' . $task['description'] . '</td>';
                                echo '<td>' . explode(' ',$task['due_date'])[0] . '</td>';
                                echo '<td>' . $task['username'] . '</td>';
                                echo '<td>' . $task['tag'] . '</td>';
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
    const search = document.getElementById("mySearch");
    search.addEventListener("keyup", searchTask);

    function searchTask() {
        sendAjaxRequest('post', '/api/project/{{$project->id}}/tasks-search', {
            search: search.value
        }, mySearchHandler);
    }

    function mySearchHandler() {
        //if(this.status != 200) window.location = '/';
        let tasks = JSON.parse(this.responseText);
        let body = document.getElementById("table-tasks-body");

        let paginations = document.getElementsByClassName('pagination');

        for (let pag of paginations) {
            if (document.getElementById('publicCardBody').contains(pag)) {
                if (search.value !== "") {
                    pag.style.display = 'none';
                } else {
                    if (tasks.length > 10)
                        pag.style.display = 'flex';
                }
            }
        }

        body.innerHTML = "";
        let count = 0;
        for (let task of tasks) {
            if (count === 10) break;
            count++;
            let tr = body.insertRow();
            let link = tr.insertCell();
            link.classList.add('text-center');
            link.innerHTML = '<a class="text-info my-rocket" href="/project/' + task['project_id'] + '/tasks/' + task['id'] + '"><i class="icon-rocket"><\/i><\/a>';
            let title = tr.insertCell();
            title.innerHTML = task['name'];
            let description = tr.insertCell();
            description.innerHTML = task['description'];
            let duedate = tr.insertCell();
            duedate.innerHTML = task['due_date'];
            let assignee = tr.insertCell();
            assignee.innerHTML = '';
            let stage = tr.insertCell();
            stage.innerHTML = task['tag'];
        }
    }
</script>
@endsection
