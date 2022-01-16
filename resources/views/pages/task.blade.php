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
        <div class="d-flex gap-4 mt-4 container align-items-center text-uppercase">
            <h3><a class="text-decoration-none" href="/project/{{$project->id}}">{{$project->title}}</a> / <a class="text-decoration-none" href="/project/{{$project->id}}/tasks">Tasks</a> / Files</h3>
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
                            <button type="submit" name="action" value="update" class="btn green-btn">Update Task</button>
                            <?php if ($user_role === 'MANAGER') { ?>
                                <button type="submit" name="action" value="delete" class="btn btn-outline-danger">Delete Task</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-4 container align-items-center">
            <h3>Comments</h3>
        </div>
        <div class="col-md-12 px-4 my-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3" style="max-height:60vh;overflow:auto;">
                        <div class="">
                            <div id="table-tasks-body">
                                <?php
                                //dd($task_comments);
                                foreach ($task_comments as $comment) {
                                    $path = '/images/no_img.png';
                                    if (!is_null($comment->user->img_url) && file_exists(public_path($comment->user->img_url))) {
                                        $path = $comment->user->img_url;
                                    }
                                    echo '<div class="d-flex align-items-center bg-light">';
                                    echo '<div><img style="border-radius: 50%; max-width: 70%; max-height: 70px" src="' . asset($path) . '"></div>';
                                    echo '<div class="p-2 w-100 bd-highlight"><a href="/profile/' . $comment->user->id . 'style="font-weight: bold; text-decoration: none" class="text-black fs-5">' . $comment->user->username . '</a></div>';
                                    echo '<div class="flex-shrink-1 bd-highlight">' . $comment->created_at . '</div>';
                                    echo '</div>';
                                    echo '<div style="margin-left: 5%; font-size: medium">' . $comment->comment . '</div>';
                                    echo '<hr/>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $task_comments->links() }}
                    </div>
                    <form action="/project/{{$project->id}}/task/{{$task->id}}/comment" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <textarea name="comment" class="form-control" aria-label="With textarea" rows="3" placeholder="Write new comment"></textarea>
                            </div>
                            <div class="col-md-3 align-items-center justify-content-center" style="display: flex;">
                                <button type="submit" name="action" class="btn btn-secondary h-50">Send <i class="icon-rocket"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
