@extends('layouts.app')

@section('title', 'Tasks')

@section('topnavbar')
@include('partials.navbar')
@endsection

@section('content')

    <div class="row m-0">
        <div class="col-2">
    @include('partials.project_nav', ['project' => $project])
        </div>
        <div class="col-md-7">
            <div class="container text-center my-3">
                <h2>All Tasks</h2>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <a href="projectsCreate" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-magnifier"></i></a>
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
                            <tbody>
                            <?php
                            foreach ($tasks_ALL as $task) {
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