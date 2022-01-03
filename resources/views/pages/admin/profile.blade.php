@extends('layouts.app')

@section('title', 'Profile')

@section('topnavbar')
@include('partials.adminnavbar')
@endsection

@section('content')
        <div class="row m-0 justify-content-center">
            <div class="col-md-7">
                <div class="container">
                    <form action="/profile/{{$user->id}}/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <?php
                        $path = '/images/no_img.png';
                        if (!is_null($user->img_url) && file_exists(public_path($user->img_url))) {
                            $path = $user->img_url;
                        }
                        ?>
                        <div class="mt-3 container text-center align-items-center">
                            <img src="{{ asset($path) }}" style="max-width: 200px">
                            <p><?php echo $user->username; ?></p>
                        </div>
                        <div class="card my-3">
                            <div class="card-header">
                                Edit Profile
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input name="img_url" class="form-control" type="file" id="formFile" multiple>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Full Name: </span>
                                    </div>
                                    <input name="fullname" type="text" class="form-control" placeholder="Username" value="{{$user->fullname}}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Username: </span>
                                    </div>
                                    <input name="username" type="text" class="form-control" placeholder="Username" value="{{$user->username}}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"> Email: </span>
                                    </div>
                                    <input name="email" type="text" class="form-control" placeholder="Username" value="{{$user->email}}">
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">Update Profile</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="/profile/{{$user->id}}/update-password" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                Change Password
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Password: </span>
                                    </div>
                                    <input name="password" type="password" class="form-control" placeholder="Type a new password">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Password Confirmation: </span>
                                    </div>
                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm password">
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success">Update Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection