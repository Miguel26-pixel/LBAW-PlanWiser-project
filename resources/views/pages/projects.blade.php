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
                </div>
            </div>
        </div>
    </div>
@endsection
