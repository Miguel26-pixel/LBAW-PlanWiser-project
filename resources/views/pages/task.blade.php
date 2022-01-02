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
                            @if ($errors->has('name'))
                                <div class="field">
                                    <span class="error">
                                        {{ $errors->first('name') }}
                                    </span>
                                </div>
                            @endif

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Description: </span>
                                </div>
                                <input name="description" type="text" class="form-control" placeholder="Description" value="{{$task->description}}">
                            </div>
                            @if ($errors->has('description'))
                                <div class="field">
                                    <span class="error">
                                        {{ $errors->first('description') }}
                                    </span>
                                </div>
                            @endif

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Status:</span>
                                </div>
                                <select name="tag" class="form-select" aria-label="Disabled select example">
                                    <option selected value="{{$task['tag']}}">{{$task['tag']}}</option>
                                    @if ($task['tag'] != 'TODO')
                                        <option value='TODO'>TODO</option>
                                    @endif 
                                    @if($task['tag'] != 'DOING')
                                        <option value='DOING'>DOING</option>
                                    @endif 
                                    @if ($task['tag'] != 'REVIEW')
                                        <option value='REVIEW'>REVIEW</option>
                                    @endif 
                                    @if ($task['tag'] != 'CLOSED')
                                        <option value='CLOSED'>CLOSED</option>
                                    @endif
                                </select>
                            </div>
                            @if ($errors->has('tag'))
                                <span class="error">
                                    {{ $errors->first('tag') }}
                                </span>
                            @endif

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
                            @if ($errors->has('username'))
                                <span class="error">
                                    {{ $errors->first('user_id') }}
                                </span>
                            @endif

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"> Due Date: </span>
                                </div>
                                <?php
                                $task->due_date = explode(' ', $task->due_date)[0];
                                ?>
                                <input name="due_date" type="date" class="form-control" value="{{$task->due_date}}">
                            </div>
                            @if ($errors->has('due_date'))
                                <span class="error">
                                    {{ $errors->first('due_date') }}
                                </span>
                            @endif

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"> Reminder Date: </span>
                                </div>
                                <?php
                                    $task->reminder_date = explode(' ', $task->reminder_date)[0];
                                ?>
                                <input name="reminder_date" type="date" class="form-control" value="{{$task->reminder_date}}">
                            </div>
                            @if ($errors->has('reminder_date'))
                                <span class="error">
                                    {{ $errors->first('reminder_date') }}
                                </span>
                            @endif

                            <div class="col-md-12 text-center">
                                <button type="submit" name="action" value="update" class="btn btn-success">Update Task</button>
                                <button type="submit" name="action" value="delete" class="btn btn-outline-danger">Delete Task</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

