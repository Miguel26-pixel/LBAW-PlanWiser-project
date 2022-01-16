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


<div class="row">
    <div class="col-sm-2">
        @include('partials.project_nav', ['project' => $project])
    </div>
    <div class="col-sm-8">
        <div class="d-flex gap-4 mt-4 container align-items-center text-uppercase">
            <h3><a class="text-decoration-none" href="/project/{{$project->id}}">{{$project->title}}</a> / About</h3>
        </div>
        <div class="col-md-12 px-4 my-4">
            <div class="card my-3">
                <div class="card-body d-flex flex-column">
                    <div style="border-radius: 5px; align-self: center; background-color: hsla(180, 25%, 33%, 0.801); color: white; width: 100%; text-align: center; padding: 1em">
                        <h3>{{$project->title}}</h3>
                    </div>
                    <div class="mt-5 mb-5">
                        <h4 style="color: hsla(180, 25%, 33%, 0.801);" class="text-center col-md-12 mb-4">Description</h4>
                        <div style="border-style:solid ;border-color:  hsla(180, 25%, 33%, 0.801); padding: 1em;  border-radius: 5px;">{{$project->description}}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center" style="gap: 10vw">
                        <div class="mb-3 text-align-center text-center">
                            <h5 style="color: #2f4f4f; font-weight: bold">Visibility:</h5>
                            {{($project->public) ? 'Public' : 'Private'}}
                        </div>
                        <div class="mb-3 text-center">
                            <h5 style="color: #2f4f4f; font-weight: bold">State:</h5>
                            {{($project->active) ? 'Active' : 'Archived'}}
                        </div>
                    </div>
                    <?php if ($user_role === 'MANAGER') { ?>
                        <div class="text-center">
                            <a href="{{$project->id}}/edit" class="btn green-btn mt-5"> Edit Project</a>
                        </div>
                    <?php } ?>
                </div>
                <div class="bg-light pt-3 pb-3 d-flex justify-content-around">
                    <div class="justify-flex-start">
                        <a class="btn btn-danger mb-2" href="/project/{{$project->id}}/{{($is_fav) ? 'remove-fav' : 'add-fav'}}">
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
                    <div class="text-center">
                        <h3>
                            <?php
                            if ($is_fav) {
                                echo '<i class="fa fa-heart" style="color:red"></i>';
                            } else {
                                echo '<i class="icon-heart" style="color: red"></i>';
                            }
                            ?>
                            {{$num_favs}}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="card my-3">
            <div class="card-body">
                <br>
                <div class="d-flex row">
                    <div class="col-md-4" style="max-height: 300px; overflow: auto; border-right: 1px solid lightgray">
                        <h4 class="text-center">Managers ({{count($admins->toArray())}})</h4>
                        <?php
                        foreach ($admins as $admin) {
                            $path = '/images/no_img.png';
                            if (!is_null($admin->img_url) && file_exists(public_path($admin->img_url))) {
                                $path = $admin->img_url;
                            }
                            echo '<div class="row m-0 my-4" style="display: flex;align-items: center;justify-content: center;">';
                            echo '<img class="col-sm-3" style="object-fit: contain; max-height: 60px" src="' . asset($path) . '">';
                            echo '<div class="col-md-6">';
                            echo $admin->username;
                            echo '</div>';
                            if (!(Auth::check() && $admin->id === Auth::id())) {
                                echo '<a href="mailto:' . $admin->email . '" class="col-md-3 btn btn-outline-success">';
                                echo '<i class="icon-envelope"></i>';
                                echo '</a>';
                            } else {
                                echo '<div class="col-md-3"></div>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="col-md-4" style="max-height: 300px; overflow: auto; border-right: 1px solid lightgray">
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
                    <div class="col-md-4" style="max-height: 300px; overflow: auto">
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
                </div>
                <br>
                <div class="col-md-12 text-center">
                    <?php
                    if ($user_role !== 'GUEST') {
                        echo '<div class="float-right text-center">';
                        echo '<a class="btn btn-outline-danger float-right" href="/project/{{$project->id}}/leave">Leave Project <i class="icon-logout"></i></a>';
                        echo '</div>';
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
