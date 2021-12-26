@extends('layouts.app')

@section('title', 'Projects')

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
                        <a href="projectsCreate" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-plus"></i> New Project</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-success" >
                            <tr>
                                <th scope="col" style="width: 5%">#</th>
                                <th scope="col">Project</th>
                                <th scope="col" style="width: 55%">Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count=1;
                            foreach ($my_projects as $project) {
                                echo '<tr>';
                                echo '<th scope="row">'.$count.'</th>';
                                echo '<td>'.$project['title'].'</td>';
                                echo '<td>'.$project['description'].'</td>';
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
                        <a href="projectsCreate" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-magnifier"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-success" >
                            <tr>
                                <th scope="col" style="width: 5%">#</th>
                                <th scope="col">Project</th>
                                <th scope="col" style="width: 55%">Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $count=1;
                            foreach ($public_projects as $project) {
                                echo '<tr>';
                                echo '<th scope="row">'.$count.'</th>';
                                echo '<td>'.$project['title'].'</td>';
                                echo '<td>'.$project['description'].'</td>';
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
