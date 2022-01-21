@extends('layouts.app')

@section('title', 'Projects')

@section('topnavbar')
@include('partials.adminnavbar')
@endsection

@section('content')

<div class="row m-0 justify-content-center" style="padding-top: 150">
    <div class="col-md-7">
        <div class="container">
            <form action="createUser" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card my-3">
                    <div class="card-header">
                        Create Profile
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Full Name: </span>
                            </div>
                            <input name="fullname" type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Username: </span>
                            </div>
                            <input name="username" type="text" class="form-control" placeholder="Username">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" name="is_admin" type="checkbox" value="true" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Admin
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Create Account
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"> Email: </span>
                            </div>
                            <input name="email" type="text" class="form-control" placeholder="Username">
                        </div>
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
                    </div>
                </div>
                <div class="pt-5 text-center">
                    <button type="submit" class="btn btn-success">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
