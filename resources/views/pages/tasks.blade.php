@extends('layouts.app')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('title', 'Tasks')

@section('content')

    <div class="row m-0">
        <div class="col-2">
    @include('partials.project_nav', ['project' => $project])
        </div>
        <div class="col-md-9">
            <div class="container text-center my-3">
                <h2>All Tasks</h2>
            </div>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <form  method="POST" action="/project/{{$project->id}}/tasks-search" enctype="multipart/form-data" class="input-group rounded w-50">
                        {{@csrf_field()}}
                            <input type="search" name="search" id="mySearch" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        </form> 
                        <a href="tasksCreate" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-plus"></i> New Task</a>
                    </div>
                    
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-success" >
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
                                echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/project/'.$project['id'].'/task/'.$task['id'].'"><i class="icon-rocket"></i></a></th>';
                                echo '<td>'.$task['name'].'</td>';
                                echo '<td>'.$task['description'].'</td>';
                                echo '<td>'.$task['due_date'].'</td>';
                                echo '<td>'.$task['username'].'</td>';
                                echo '<td>'.$task['tag'].'</td>';
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
            console.log('/project/{{$project->id}}/tasks-search');
            sendAjaxRequest('post', '/project/{{$project->id}}/tasks-search', {search: search.value}, mySearchHandler);
        }
        function mySearchHandler() {
            //if(this.status != 200) window.location = '/';
            let tasks = JSON.parse(this.responseText);
            console.log(tasks);
            let body = document.getElementById("table-tasks-body");

            body.innerHTML = "";

            for(let task of tasks.data) {
                let tr = body.insertRow();
                let link = tr.insertCell();
                link.classList.add('text-center');
                link.innerHTML = '<a class="text-info my-rocket" href="/project/' + task['project_id'] + '/tasks/' + task['id'] + '"><i class="icon-rocket"></i></a>';
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
