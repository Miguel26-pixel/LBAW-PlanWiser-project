@extends('layouts.app')

@section('title', 'Profile')

@section('topnavbar')
<?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) { ?>
    @include('partials.adminnavbar')
<?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
<?php } ?>
@endsection

@section('content')
<div class="row m-0 d-flex flex-direction-column justify-content-center my-5">
    <div class="col-md-1"></div>
    <div class="col-md-10">
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
                    <img alt="User picture" src="{{ asset($path) }}" style="max-width: 200px">
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

        <div class="container text-center my-3">
            <h2>My Favourite Projects</h2>
        </div>
        <div class="container">
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                        <th scope="col">Project</th>
                        <th scope="col" style="width: 55%">Description</th>
                        <th scope="col" class="text-center" style="width: 10%">Unfav</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($fav_projects as $fav_project) {
                        echo '<tr>';
                        echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/project/' . $fav_project['id'] . '"><i class="icon-rocket"></i></a></th>';
                        echo '<td>' . $fav_project['title'] . '</td>';
                        echo '<td>' . $fav_project['description'] . '</td>';
                        echo '<td class="text-center"><a class="btn btn-outline-danger" href="/project/' . $fav_project['id'] . '/remove-fav"><i class="icon-dislike"></i></td>';
                        echo '</tr>';
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $fav_projects->links() }}
            </div>

            <div class="container text-center my-3">
                <h2>Options</h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="/profile/{{$user->id}}/delete" method="POST">
                        @csrf
                        <h4 class="text-center">Delete Account</h4>
                        <p><span class="text-danger"><i class="icon-shield"></i> Warning: </span>To delete your account click on button below.<br>Be careful because there is no way back after delete the account!</p>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-danger">Delete my Account</button>
                        </div>
                    </form>
                    <br>
                    <h4 class="text-center">Make a report</h4>
                    <p><span class="text-danger"><i class="icon-shield"></i> Warning: </span> To make a report click on button below.
                        <br>The creation of a report will send an email to the support.
                        It is possible to report a user or a bug in the program.
                        <br> The answer will be send to your email of this account
                    </p>
                    <div class="col-md-12 text-center">
                        <a href="/reportBug" class="btn btn-danger">Make a Report</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>
@endsection
