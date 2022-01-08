@extends('layouts.app')

@section('topnavbar')
@include('partials.navbar')
@endsection

@section('title', 'ProjectUsers', ['notifications' => $notifications])

@section('content')

    <div class="row m-0">
        <div class="col-2">
            @include('partials.project_nav', ['project' => $project])
        </div>
        <div class="col-10">
            <div class="mt-4 container align-items-center">
                <h3>Project Members</h3>
            </div>
            <div class="col-md-12 px-4">
                <div class="card my-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Project Members
                        <?php if ($user_role === 'MANAGER') { ?>
                        <a href="/project/{{$project->id}}/members/invitation" class="btn btn-outline-success" style="border-style:hidden;"><i class="icon-plus"></i> Add Member</a>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-success" >
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                                <th scope="col">Username</th>
                                <th scope="col" style="width: 45%">Email</th>
                                <th scope="col" style="width: 20%">Role</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($project_users as $user) {
                                echo '<tr>';
                                echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href=""><i class="icon-rocket"></i></a></th>'; //TODO href
                                echo '<td>'.$user["username"].'</td>';
                                echo '<td>'.$user['email'].'</td>';
                                echo '<td>'.$user['user_role'].'</td>';
                                echo '</tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
