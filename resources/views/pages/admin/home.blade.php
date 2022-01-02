@extends('layouts.app')

@section('title', 'AdminDashBoard')

@section('topnavbar')
@include('partials.adminnavbar')
@endsection

@section('content')

<div class="row m-0  justify-content-center">
    <div class="col-md-5 mt-5">
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    New Users
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($users as $user) {
                                if($count >= 4){
                                    break;
                                }
                                $path = '/images/users/no_img.png';
                                if (!is_null($user->img_url) && file_exists(public_path($user->img_url))) {
                                    $path = $user->img_url;
                                }
                                echo '<tr>';
                                echo '<td><div class="d-flex gap-3">';
                                echo '<a href="admin/profile/' . $user['id'] . '"><img src="' . asset($path) . '"class="img-fluid mx-auto d-block rounded-circle" style="width: 50px; height: 50px""></a>';
                                echo '<a href="admin/profile/' . $user['id'] . '"><div style="font-weight: bold; color: black">' . $user['username'] . '</div><p style="color: grey">' . $user['email'] . '</p></a>';
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
    <!-- <div class="col-md-5 mt-5">
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Latest Reports
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <?php
                        $count = 1;
                        foreach ($users as $user) {
                            $path = '/images/users/no_img.png';
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
    </div> -->
</div>
<div class="row m-0  justify-content-center">
    <div class="col-md-5 mt-5">
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    New Projects
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                                <th scope="col">Project</th>
                                <th scope="col" style="width: 55%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($public_projects as $project) {
                                if($count >= 4){
                                    break;
                                }
                                echo '<tr>';
                                echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/project/' . $project['id'] . '"><i class="icon-rocket"></i></a></th>';
                                echo '<td>' . $project['title'] . '</td>';
                                echo '<td>' . $project['description'] . '</td>';
                                echo '</tr>';
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $public_projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-md-5 mt-5">
        <div class="container text-center my-3">
            <h2>Numbers</h2>
        </div>
        <div class="container">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th scope="col" class="text-center" style="width: 5%"><i class="icon-arrow-right-circle"></i></th>
                            <th scope="col">Project</th>
                            <th scope="col" style="width: 55%">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 1;
                        foreach ($public_projects as $project) {
                            echo '<tr>';
                            echo '<th scope="row" class="text-center"><a class="text-info my-rocket" href="/project/' . $project['id'] . '"><i class="icon-rocket"></i></a></th>';
                            echo '<td>' . $project['title'] . '</td>';
                            echo '<td>' . $project['description'] . '</td>';
                            echo '</tr>';
                            $count++;
                        }
                        ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $public_projects->links() }}
                </div>
            </div>
        </div>
    </div> -->
</div>
@endsection