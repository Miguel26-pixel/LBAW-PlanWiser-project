@extends('layouts.app')

@section('title', 'Task')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('content')
        <div class="row m-0">
            <div class="col">
                <div class="container">
                    <form action="/project/{{$project->id}}/task/{{$task->id}}/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3 container text-center align-items-center">
                            <p><?php echo $task->name; ?></p>
                        </div>
                        <div class="card my-3">
                            <div class="card-header">
                                Edit Task
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Name: </span>
                                    </div>
                                    <input name="name" type="text" class="form-control" placeholder="Name" value="{{$task->name}}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Description: </span>
                                    </div>
                                    <input name="description" type="text" class="form-control" placeholder="Description" value="{{$task->description}}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"> Due Date: </span>
                                    </div>
                                    <?php
                                    $task->due_date = explode(' ', $task->due_date)[0];
                                    ?>
                                    <input name="due_date" type="date" class="form-control" value="{{$task->due_date}}">
                                    
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"> Tag: </span>
                                    </div>
                                    <select name="tag" class="form-select" aria-label="Disabled select example">
                                        <option value='TODO'>TODO</option>
                                        <option value='DOING'>DOING</option>
                                        <option value='REVIEW'>REVIEW</option>
                                        <option value='CLOSED'>CLOSED</option>
                                    </select>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">Update Task</button>
                                </div>
                            </div>
                        </div>
                    </form>
@endsection