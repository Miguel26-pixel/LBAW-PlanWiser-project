@extends('layouts.app')

@section('title', 'Task')

@section('topnavbar')
    <?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) {?>
    @include('partials.adminnavbar')
    <?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
    <?php } ?>
@endsection

@section('content')
        <div class="row m-0">
            <div class="col-md-2"> @include('partials.project_nav', ['project' => $project])</div>
            <div class="col-md-10">
                <div class="mt-4 container align-items-center">
                    <h3><?php echo $task->name; ?></h3>
                </div>
                <div class="col-md-12 px-4 my-4">
                    <form action="/project/{{$project->id}}/task/{{$task->id}}/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card ">
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
                                        <span class="input-group-text" id="basic-addon1">Status:</span>
                                    </div>
                                    <select name="tag" class="form-select" aria-label="Disabled select example">
                                        <option value='TODO' {{($task->tag == "TODO") ? 'selected' : ''}}>TODO</option>
                                        <option value='DOING' {{($task->tag == "DOING") ? 'selected' : ''}}>DOING</option>
                                        <option value='REVIEW' {{($task->tag == "REVIEW") ? 'selected' : ''}}>REVIEW</option>
                                        <option value='CLOSED' {{($task->tag == "CLOSED") ? 'selected' : ''}}>CLOSED</option>
                                    </select>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"> Assignee: </span>
                                    </div>

                                    <select name="user_id" class="form-select" aria-label="Disabled select example">
                                        @if (count($user_assigned) == 0)
                                            <option selected value="-1"> </option>
                                            @foreach ($users as $user)
                                                    <option value="{{ $user['user_id'] }}">{{$user['username']}} </option>
                                            @endforeach
                                        @else
                                            <option selected value="{{$user_assigned[0]['user_id'] }}">{{$user_assigned[0]['username'] }}</option>
                                            <option value="-1"> </option>
                                            @foreach ($users as $user)
                                                @if ($user_assigned[0]['user_id'] != $user['user_id'])
                                                    <option value="{{ $user['user_id'] }}">{{$user['username']}} </option>
                                                @endif
                                            @endforeach
                                        @endif


                                    </select>
                                </div>


                                <div class="col-md-12 text-center">
                                    <button type="submit" name="action" value="update" class="btn btn-success">Update Task</button>
                                    <?php if ($user_role === 'MANAGER') { ?>
                                    <button type="submit" name="action" value="delete" class="btn btn-outline-danger">Delete Task</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

