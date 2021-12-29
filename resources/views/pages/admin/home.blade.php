@extends('layouts.app')

@section('title', 'AdminDashBoard')

@section('topnavbar')
@include('partials.adminnavbar')
@endsection

@section('content')

<div class="row m-0  justify-content-center">
    <div class="col-md-5 mt-5">
        <div class="container text-center my-3">
            <h2>New Users</h2>
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
    </div>
    <div class="col-md-5 mt-5">
        <div class="container text-center my-3">
            <h2>Latest Reports</h2>
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
    </div>
</div>
<div class="row m-0  justify-content-center">
    <div class="col-md-5 mt-5">
        <div class="container text-center my-3">
            <h2>New Projects</h2>
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
    </div>
    <div class="col-md-5 mt-5">
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
    </div>
</div>
@endsection