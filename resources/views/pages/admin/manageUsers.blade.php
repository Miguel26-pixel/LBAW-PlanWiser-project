@extends('layouts.app')

@section('title', 'ManageUsers')

@section('topnavbar')
@include('partials.adminnavbar')
@endsection

@section('content')

<div class="row m-0 justify-content-center">
    <div class="col-md-10 mt-5">
        <div class="container text-center my-3">
            <h2>Manage Users</h2>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Users
                    <form method="POST" action="/admin/searchUsers" enctype="multipart/form-data" class="input-group rounded w-50">
                        {{@csrf_field()}}
                        <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0 btn-success" id="search-addon">
                            <i class="icon-magnifier"></i>
                        </button>
                    </form>
                    <a href="createUser" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-plus"></i> New User</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($users as $user) {
                                $path = '/images/no_img.png';
                                if (!is_null($user->img_url) && file_exists(public_path($user->img_url))) {
                                    $path = $user->img_url;
                                }
                                echo '<tr>';
                                echo '<td><div class="d-flex gap-3">';
                                echo '<a href="profile/' . $user['id'] . '"><img src="' . asset($path) . '"class="img-fluid mx-auto d-block rounded-circle" style="width: 50px; height: 50px""></a>';
                                echo '<a href="profile/' . $user['id'] . '"><div style="font-weight: bold; color: black">' . $user['username'] . '</div><p style="color: grey">' . $user['email'] . '</p></a>';
                                echo '</div>';
                                echo '</td></tr>';
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
