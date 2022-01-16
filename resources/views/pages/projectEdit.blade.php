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
        @include('partials.project_nav', ['project' => $project])
    </div>
    <div class="col-sm-8">
        <div class="d-flex gap-4 mt-4 container align-items-center text-uppercase">
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
    <!-- <div class="col-md-3">
                <div class="mt-3 container text-center align-items-center">
                    <h3>More Informations</h3>
                </div>
                <div class="card my-3">
                    <div class="card-body">
                        <div class="col-md-12 text-center">
                            <a class="btn btn-outline-danger col-md-10 mb-2" href="/project/{{$project->id}}/{{($is_fav) ? 'remove-fav' : 'add-fav'}}">
                                {{($is_fav) ? 'Remove from Favorites ' : 'Add to Favorites '}}
                                <?php
                                if ($is_fav) {
                                    echo '<i class="icon-dislike"></i>';
                                } else {
                                    echo '<i class="icon-heart"></i>';
                                }
                                ?>
                            </a>
                        </div>
                        <br>
                        <div style="max-height: 150px; overflow: auto">
                            <h4 class="text-center">Managers ({{count($admins->toArray())}})</h4>
                            <?php
                            foreach ($admins as $admin) {
                                $path = '/images/no_img.png';
                                if (!is_null($admin->img_url) && file_exists(public_path($admin->img_url))) {
                                    $path = $admin->img_url;
                                }
                                echo '<div class="row m-0 my-4" style="display: flex;align-items: center;justify-content: center;">';
                                echo '<img class="col-md-3" style="object-fit: contain; max-height: 60px" src="' . asset($path) . '">';
                                echo '<div class="col-md-6">';
                                echo $admin->username;
                                echo '</div>';
                                if (!(Auth::check() && $admin->id === Auth::id())) {
                                    echo '<a href="mailto:' . $admin->email . '" class="col-md-3 btn btn-outline-success">';
                                    echo '<i class="icon-envelope"></i>';
                                    echo '</a>';
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div style="max-height: 250px; overflow: auto">
                            <h4 class="text-center">Members ({{count($members->toArray())}})</h4>
                            <?php
                            foreach ($members as $member) {
                                $path = '/images/no_img.png';
                                if (!is_null($member->img_url) && file_exists(public_path($member->img_url))) {
                                    $path = $member->img_url;
                                }
                                echo '<div class="row m-0 my-4" style="display: flex;align-items: center;justify-content: center;">';
                                echo '<img class="col-md-3" style="object-fit: contain; max-height: 60px" src="' . asset($path) . '">';
                                echo '<div class="col-md-6">';
                                echo $member->username;
                                echo '</div>';
                                if ($user_role !== 'GUEST') {
                                    if (!(Auth::check() && $member->id === Auth::id())) {
                                        echo '<a href="mailto:' . $member->email . '" class="col-md-3 btn btn-outline-success">';
                                        echo '<i class="icon-envelope"></i>';
                                        echo '</a>';
                                    }
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div style="max-height: 250px; overflow: auto">
                            <h4 class="text-center">Guests ({{count($guests->toArray())}})</h4>
                            <?php
                            foreach ($guests as $guest) {
                                $path = '/images/no_img.png';
                                if (!is_null($guest->img_url) && file_exists(public_path($guest->img_url))) {
                                    $path = $guest->img_url;
                                }
                                echo '<div class="row m-0 my-4" style="display: flex;align-items: center;justify-content: center;">';
                                echo '<img class="col-md-3" style="object-fit: contain; max-height: 60px" src="' . asset($path) . '">';
                                echo '<div class="col-md-6">';
                                echo $guest->username;
                                echo '</div>';
                                if ($user_role == 'MANAGER') {
                                    echo '<a href="mailto:' . $guest->email . '" class="col-md-3 btn btn-outline-success">';
                                    echo '<i class="icon-envelope"></i>';
                                    echo '</a>';
                                }
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <br>
                        <div class="col-md-12 text-center">
                            <h3 class="text-danger"><i class="icon-heart"></i> : {{$num_favs}} </h3>
                        </div>

                        <div class="col-md-12 text-center">
                            <a class="btn btn-outline-danger col-md-10" href="/project/{{$project->id}}/leave">Leave Project <i class="icon-logout"></i></a>
                        </div>
                    </div>
                </div>
            </div> -->
</div>
</div>
</div>


@endsection
