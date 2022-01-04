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
                    <div class="input-group rounded w-50">
                        <input id="mySearch" type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="button" class="input-group-text border-0" id="search-addon">
                            <i class="icon-magnifier"></i>
                        </button>
                    </div>
                    <a href="projectsCreate" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-plus"></i> New Project</a>
                </div>
                <div id="myCardBody" class="card-body">
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
                    <div class="input-group rounded w-50">
                        <input id="publicSearch" type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon">
                            <i class="icon-magnifier"></i>
                        </button>
                    </div>
                </div>
                <div id="publicCardBody" class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                                <th scope="col">Project</th>
                                <th scope="col" style="width: 55%">Description</th>
                            </tr>
                        </thead>
                        <tbody id="table-projects-body">
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
    const mysearch = document.getElementById("mySearch");
    mysearch.addEventListener("keyup", searchProject);
    function searchProject() {
        sendAjaxRequest('post', '/api/myProjectsSearch', {search: mysearch.value}, mySearchHandler);
    }
    function mySearchHandler() {
        //if(this.status != 200) window.location = '/';
        let projects = JSON.parse(this.responseText);
        let body = document.getElementById("table-myprojects-body");

        let paginations = document.getElementsByClassName('pagination');

        for (let pag of paginations) {
            if (document.getElementById('myCardBody').contains(pag)) {
                if (mysearch.value !== "") {
                    pag.style.display = 'none';
                } else {
                    if (projects.data.length > 10)
                        pag.style.display = 'flex';
                }
            }
        }

        body.innerHTML = "";
        let count = 0;
        for(let project of projects.data) {
            if (count === 10) break;
            count++;
            let tr = body.insertRow();
            let link = tr.insertCell();
            link.classList.add('text-center');
            link.innerHTML = '<a class="text-info my-rocket" href="/project/' + project['id'] + '"><i class="icon-rocket"></i></a>';
            let title = tr.insertCell();
            title.innerHTML = project['title'];
            let description = tr.insertCell();
            description.innerHTML = project['description'];
        }
    }
    const publicsearch = document.getElementById("publicSearch");
    publicsearch.addEventListener("keyup", searchPublicProject);
    function searchPublicProject() {
        sendAjaxRequest('post', '/api/publicProjectsSearch', {search: publicsearch.value}, publicSearchHandler);
    }
    function publicSearchHandler() {
        //if(this.status != 200) window.location = '/';
        let projects = JSON.parse(this.responseText);
        let body = document.getElementById("table-projects-body");

        let paginations = document.getElementsByClassName('pagination');

        for (let pag of paginations) {
            if (document.getElementById('publicCardBody').contains(pag)) {
                if (publicsearch.value !== "") {
                    pag.style.display = 'none';
                } else {
                    if (projects.data.length > 10)
                        pag.style.display = 'flex';
                }
            }
        }

        body.innerHTML = "";
        let count = 0;
        for(let project of projects.data) {
            if (count === 10) break;
            count++;
            let tr = body.insertRow();
            let link = tr.insertCell();
            link.classList.add('text-center');
            link.innerHTML = '<a class="text-info my-rocket" href="/project/' + project['id'] + '"><i class="icon-rocket"></i></a>';
            let title = tr.insertCell();
            title.innerHTML = project['title'];
            let description = tr.insertCell();
            description.innerHTML = project['description'];
        }
    }
    </script>
@endsection
