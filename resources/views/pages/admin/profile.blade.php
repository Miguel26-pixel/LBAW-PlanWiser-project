@extends('layouts.app')

@section('title', 'Profile')

@section('topnavbar')
@include('partials.adminnavbar')
@endsection

@section('content')
    <div class="row m-0 justify-content-center">
        <?php
        $path = '/images/no_img.png';
        if (!is_null($user->img_url) && file_exists(public_path($user->img_url))) {
            $path = $user->img_url;
        }
        ?>
        <div class="mt-3 container text-center align-items-center">
            <img alt="User picture" src="{{ asset($path) }}" style="max-width: 200px">
            <p><?php echo $user->username; ?></p>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="container">
                <form action="/profile/{{$user->id}}/update" method="POST" enctype="multipart/form-data">
                    @csrf
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
                                <input name="fullname" type="text" class="form-control" placeholder="Full Name" value="{{$user->fullname}}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Username: </span>
                                </div>
                                <input name="username" type="text" class="form-control" placeholder="Username" value="{{$user->username}}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> Email: </span>
                                </div>
                                <input name="email" type="text" class="form-control" placeholder="Email" value="{{$user->email}}">
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">Update Profile</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="/profile/{{$user->id}}/update-password" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-3">
                        <div class="card-header">
                            Change Password
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Password: </span>
                                </div>
                                <input name="password" type="password" class="form-control" placeholder="Type a new password">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Password Confirmation: </span>
                                </div>
                                <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm password">
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success">Update Password</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card my-3">
                    <div class="card-header">
                        Options
                    </div>
                    <div class="card-body">
                        <h3 class="text-center">Delete Account</h3>
                        <form action="/admin/profile/{{$user->id}}/delete" method="POST">
                            @csrf
                            <p><span class="text-danger"><i class="icon-shield"></i> Warning: </span>To delete this account click on button below.<br>Be careful because there is no way back after delete the account!</p>
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Delete Account</button>
                            </div>
                        </form>
                        <br>
                        @if (!$user->is_banned && Illuminate\Support\Facades\Auth::id() != $user->id)
                            <h3 class="text-center">Ban Account</h3>
                            <form action="/admin/profile/{{$user->id}}/ban" method="POST">
                                @csrf
                                <p><span class="text-danger"><i class="icon-shield"></i> Warning: </span>To ban this account click on button below.<br>After banning a user, he cannot access anything!</p>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger">Ban Account</button>
                                </div>
                            </form>
                        @elseif(Illuminate\Support\Facades\Auth::id() != $user->id)
                            <h3 class="text-center">Unban Account</h3>
                            <form action="/admin/profile/{{$user->id}}/unban" method="POST">
                                @csrf
                                <p><span class="text-danger"><i class="icon-shield"></i> Warning: </span>To unban this account click on button below.<br>After unbanning a user, he can access anything!</p>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Unban Account</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
@endsection
