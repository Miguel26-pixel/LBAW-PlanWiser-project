@extends('layouts.app')

@section('title', 'Project')

@section('topnavbar')
<?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) { ?>
    @include('partials.adminnavbar')
<?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
<?php } ?>
@endsection

@section('content')
<div class="row m-0">
    <div class="col-sm-2">
        @include('partials.project_nav', ['project' => $project])
    </div>
    <div class="col-sm-8">
        <div class="d-flex gap-4 mt-4 container align-items-center text-uppercase">
            <h3><a class="text-decoration-none text-success" href="/project/{{$project->id}}">{{$project->title}}</a> / Forum</h3>
        </div>
        <div class="col-md-12 px-4 my-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3" style="max-height:60vh;overflow:auto;">
                        <table class="table table-bordered overflow-scroll">
                            <thead class="table-success">
                                <tr>
                                    <th scope="col" class="text-center" style="width: 4%"><i class="icon-user"></i></th>
                                    <th scope="col" style="width: 10%">User</th>
                                    <th scope="col">Message</th>
                                    <th scope="col" style="width: 10%">Date</th>
                                </tr>
                            </thead>
                            <tbody id="table-tasks-body">
                                <?php
                                foreach ($messages as $message) {
                                    $path = '/images/no_img.png';
                                    if (!is_null($message->user->img_url) && file_exists(public_path($message->user->img_url))) {
                                        $path = $message->user->img_url;
                                    }
                                    echo '<tr>';
                                    echo '<td><img style="border-radius: 50%; max-width: 100%; max-height: 70px" src="' . asset($path) . '"></td>';
                                    echo '<td><a href="/profile/' . $message->user->id . '" class="text-black" style="text-decoration: none">' . $message->user->username . '</td>';
                                    echo '<td>' . $message->message . '</td>';
                                    echo '<td>' . $message->created_at . '</td>';
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $messages->links() }}
                    </div>
                    <form action="/project/{{$project->id}}/forum/send" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-10">
                                <textarea name="message" class="form-control" aria-label="With textarea" rows="3" placeholder="Write new message to forum"></textarea>
                            </div>
                            <div class="col-md-2 align-items-center justify-content-center" style="display: flex;">
                                <button type="submit" name="action" class="btn btn-secondary">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
