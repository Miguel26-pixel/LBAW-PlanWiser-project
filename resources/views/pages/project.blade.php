@extends('layouts.app')

@section('title', 'Project')

@section('topnavbar')
@include('partials.navbar')
@endsection

@section('content')
    <div class="row m-0">
        <div class="col-md-2 p-0 position-relative">
            @include('partials.project_nav', ['project' => $project])
        </div>
        <div class="col-md-10">
            <div style="height: 1080px">
                Olá
            </div>
        </div>
    </div>


@endsection
