@extends('layouts.app')

@section('title', 'Project')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('content')


        <div class="row m-0">
        <div class="col-2">
    @include('partials.project_nav', ['project' => $project])
        </div>
            <div class="col">
                <div class="container">
                    <form action="/project/{{$project->id}}/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3 container text-center align-items-center">
                            <p><?php echo $project->title; ?></p>
                        </div>
                        <div class="card my-3">
                            <div class="card-header">
                                {{$project->title}}
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Title: </span>
                                    </div>
                                    <input name="title" type="text" class="form-control" placeholder="Title" value="{{$project->title}}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Description: </span>
                                    </div>
                                    <input name="description" type="text" class="form-control" placeholder="Description" value="{{$project->description}}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"> Tag: </span>
                                    </div>
                                    <select name="public" class="form-select" >
                                        <option value="True">True</option>
                                        <option value="False">False</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"> Active: </span>
                                    </div>
                                    <select name="active" class="form-select">
                                        <option value="True">True</option>
                                        <option value="False">False</option>
                                    </select>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">Update Project</button>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
        </div>



@endsection
