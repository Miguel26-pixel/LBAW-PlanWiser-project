<?php

use Illuminate\Support\Facades\Auth;
?>

@extends('layouts.app')

@section('title', 'Project')

@section('topnavbar')
<?php if (Auth::check() && Auth::user()->is_admin) { ?>
    @include('partials.adminnavbar')
<?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
<?php } ?>
@endsection

@section('content')


<div class="row m-0">
    <div class="col-sm-2">
        @include('partials.project_nav', ['project' => $project, 'user_role' => $user_role])
    </div>
    <div class="col-sm-8">
        <div class="d-flex gap-4 mt-5 container align-items-center text-uppercase">
            <h3><a class="text-decoration-none text-success" href="/project/{{$project->id}}">{{$project->title}}</a> / Edit</h3>
        </div>
        <form action="/project/{{$project->id}}/update" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card my-3">

                <div class="card-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Title: </span>
                        </div>
                        <input name="title" type="text" class="form-control" placeholder="Title" value="{{$project->title}}">
                    </div>
                    <div class="input-group mb-3">
                        <h5 class="text-center col-md-12">Description</h5>
                        <div class="input-group">
                            <!--span class="input-group-text">Description:</span-->
                            <textarea name="description" class="form-control" aria-label="With textarea" rows="10" placeholder="Description">{{$project->description}}</textarea>
                        </div>
                    </div>
                    <div class="row m-0 col-md-12 ">
                        <div class="col-lg-6 mb-3 gap-5">
                            <p class="font-weight-bold">
                                Visibility:
                            </p>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="public" id="exampleRadios1" value="True" {{($project->public) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Public
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="public" id="exampleRadios2" value="False" {{!($project->public) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="exampleRadios2">
                                        Private
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3  gap-5">
                            <p class="font-weight-bold">
                                State:
                            </p>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="active" id="exampleRadios3" value="True" {{($project->active) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="exampleRadios4">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="active" id="exampleRadios4" value="False" {{!($project->active) ? 'checked' : ''}}>
                                    <label class="form-check-label" for="exampleRadios3">
                                        Archived
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($user_role === 'MANAGER') { ?>
                        <div class="col-md-12 text-center">
                            <button type="submit" name="action" value="update" class="btn green-btn">Update Project</button>
                            <button type="submit" name="action" value="delete" class="btn btn-outline-danger">Delete Project</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
