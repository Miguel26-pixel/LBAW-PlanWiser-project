@extends('layouts.app')

@section('title', 'Reports')

@section('topnavbar')
@include('partials.adminnavbar')
@endsection

@section('content')

<div class="row m-0  justify-content-center">
    <div class="col-md-10 mt-5">
        <div class="container text-center my-3">
            <h2>Manage Reports</h2>
        </div>
        <div class="container">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    Reports
                    <form  method="POST" action="/admin/reports/search" enctype="multipart/form-data" class="input-group rounded w-75">
                    {{@csrf_field()}}
                        <?php $c = ($pending) ? 'checked' : '' ?>
                        <input type="checkbox" id="pending" name="pending" style="margin: 12px 10px 0 0" {{$c}}>
                        <div style="margin:8px 10px 0 0">Only Pending Reports</div>
                        <div style="width: auto; margin-right: 10px">
                            <select class="form-select" name="type" aria-label="Default select example">
                                <option value="" {{($type == "") ? 'selected' : ''}}>Type</option>
                                <option value="USER" {{($type == "USER") ? 'selected' : ''}}>User</option>
                                <option value="BUG" {{($type == "BUG") ? 'selected' : ''}}>Bug</option>
                            </select>
                        </div>
                        <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0 btn-success" id="search-addon">
                            <i class="icon-magnifier"></i>
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="text-center" style="width: 5%"><i class="icon-rocket"></i></th>
                                <th scope="col" class="text-center" style="width: 10%">State</th>
                                <th scope="col" class="text-center" style="width: 10%">User</th>
                                <th scope="col" class="text-center" style="width: 45%">Report</th>
                                <th scope="col" class="text-center" style="width: 10%">Type</th>
                                <th scope="col" class="text-center" style="width: 10%">User Reported</th>
                                <th scope="col" class="text-center" style="width: 10%">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($reports as $report) {
                                echo '<tr>';
                                if ($report->report_state == "PENDING") {
                                    echo '<td class="text-center"><a class="text-decoration-none" href="/admin/reports/'.$report->id.'/answer"><i class="text-info icon-rocket"></i></a></td>';
                                    echo '<th class="text-center text-danger">Pending</th>';
                                } else if ($report->report_state == "IGNORED") {
                                    echo '<td class="text-center"><i class="text-info icon-close"></i></td>';
                                    echo '<th class="text-center">Ignored</th>';
                                } else {
                                    echo '<td class="text-center"><i class="text-info icon-close"></i></td>';
                                    echo '<th class="text-center text-success">Done</th>';
                                }
                                echo '<td class="overflow-hidden"><a class="text-decoration-none" href="/admin/profile/'.$report->user->id.'">'.$report->user->username.'</a></td>';
                                echo '<td>'.$report->text.'</td>';
                                if ($report->report_type == 'BUG') {
                                    echo '<td class="text-center">Bug</td>';
                                    echo '<td></td>';
                                } else {
                                    echo '<td class="text-center">User</td>';
                                    echo '<td class="overflow-hidden"><a class="text-decoration-none" href="/admin/profile/'.$report->reported->id.'">'.$report->reported->username.'</a></td>';
                                }
                                echo '<td class="text-center">'.$report->created_at.'</td>';
                                echo '</tr>';
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
