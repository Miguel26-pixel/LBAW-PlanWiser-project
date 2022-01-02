@extends('layouts.app')

@section('title', 'Projects')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('content')

<div class="row m-0">
    <div class="col-md-7">
        <div class="container text-center my-3">
            <h2>My Projects</h2>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    My Projects
                    <form  method="POST" action="/myProjectsSearch" enctype="multipart/form-data" class="input-group rounded w-50">
                    {{@csrf_field()}}
                        <input id="search" type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon">
                            <i class="icon-magnifier"></i>
                        </button>
                    </form>
                    <a href="projectsCreate" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-plus"></i> New Project</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                                <th scope="col">Project</th>
                                <th scope="col" style="width: 55%">Description</th>
                            </tr>
                        </thead>
                        <tbody id="table-myprojects-body">
                            <?php
                            $count = 1;
                            foreach ($my_projects as $project) {
                                echo '<tr>';
                                echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/project/' . $project['id'] . '"><i class="icon-rocket"></i></a></th>';
                                echo '<td>' . $project['title'] . '</td>';
                                echo '<td>' . $project['description'] . '</td>';
                                echo '</tr>';
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $my_projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="container text-center my-3">
            <h2>Public Projects</h2>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Public Projects
                    <form  method="POST" action="/publicProjectsSearch" enctype="multipart/form-data" class="input-group rounded w-50">
                    {{@csrf_field()}}
                        <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon">
                            <i class="icon-magnifier"></i>
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                                <th scope="col">Project</th>
                                <th scope="col" style="width: 55%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($public_projects as $project) {
                                echo '<tr>';
                                echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/project/' . $project['id'] . '"><i class="icon-rocket"></i></a></th>';
                                echo '<td>' . $project['title'] . '</td>';
                                echo '<td>' . $project['description'] . '</td>';
                                echo '</tr>';
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $public_projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts') 
<script>
    var search = document.getElementById("search");
    search.addEventListener("keyup", searchProject);
    function searchProject() {
        sendAjaxRequest('post', '/myProjectsSearch', {search: search.value}, searchHandler);
    }
    function searchHandler() {
        if(this.status != 200) window.location = '/';

        let projects = JSON.parse(this.responseText);
        console.log(projects);
        let body = document.getElementById("table-myprojects-body");

        body.innerHTML = "";

        for(project of projects.data) {
            let tr = body.insertRow();
            let link = tr.insertCell();
            link.innerHTML = '<a class="text-info my-rocket" href="/project/' + project['id'] + '"><i class="icon-rocket"></i></a>';
            let title = tr.insertCell();
            title.innerHTML = project['title'];
            let description = tr.insertCell();
            description.innerHTML = project['description'];

        }
        

    }
    </script>
@endsection
