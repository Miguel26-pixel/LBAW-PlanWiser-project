@extends('layouts.app')

@section('title', 'Reports')

@section('topnavbar')
    @include('partials.adminnavbar')
@endsection

@section('content')
    <div class="row m-0 justify-content-center">
        <div class="col-md-7 mt-5">
            <div class="container text-center my-3">
                <h2>Answer Reports</h2>
            </div>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        Report
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center container mt-2">
                                <div>User: <a class="text-decoration-none" href="/admin/profile/{{$report->user->id}}"> {{$report->user->username }}</a></div>
                            </div>
                            <div class="col-md-4 mt-2 text-center container">
                                <div class="row m-0">
                                    <p class="col-md-12">State: <span class="text-danger">Pending</span></p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center container mt-2">
                                <div>Type: {{($report->report_type == 'USER') ? 'User Report' : 'Bug Report'}}</div>
                            </div>
                        </div>
                        <br>
                        <h5 class="text-center">Report</h5>
                        <div class="card m-4">
                            <div class="card-body">
                                {{ $report->text }}
                            </div>
                        </div>
                        <?php if ($report->report_type == 'USER') { ?>
                        <div class="col-md-12 text-center container mt-2">
                            <div>Reported User: <a class="text-decoration-none" href="/admin/profile/{{$report->reported->id}}"> {{$report->reported->username }}</a></div>
                        </div>
                        <?php } ?>
                        <br>
                        <h5 class="text-center">Answer</h5>
                        <form action="/admin/reports/{{$report->id}}/answer" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <textarea rows="5" class="form-control" name="message" placeholder="Reply message to send to the reporting user"></textarea>
                            </div>
                            <div class="col-md-12 text-center mt-3">
                                <button type="submit" name="action" value="done" class="btn btn-success">Answer Project</button>
                                <button type="submit" name="action" value="ignore" class="btn btn-outline-danger">Ignore Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
