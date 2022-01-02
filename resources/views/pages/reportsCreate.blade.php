@extends('layouts.app')

@section('report')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('content')

<div class="formbg-outer">
    <div class="formbg">
        <div class="formbg-inner" style="padding: 48px">
            <span style="padding-bottom: 15px">Make a report</span>
            <form id="stripe-login" method="POST" action='/reportsCreate'>
                {{ csrf_field() }}
                <div class="field" style="padding-bottom: 24px" required autofocus>
                    <label for="text">Report's description</label>
                    <input type="text" name="text">
                </div>
                @if ($errors->has('text'))
                <div class="field">
                    <span class="error">
                        {{ $errors->first('text') }}
                    </span>
                </div>
                @endif
                <div style="padding-bottom: 24px">
                    <label for="report_type">Report Type</label>
                    <div class="d-flex flex-direction-row align-items-center gap-5">
                        <div class="d-flex gap-2">
                            <input type="radio" id="user" name="bug" value="user">
                            <label class="pt-2 for=" user">User</label><br>
                        </div>
                        <div class="d-flex gap-2">
                            <input type="radio" id="bug" name="bug" value="bug">
                            <label class="pt-2" for="bug">Bug</label><br>
                        </div>
                    </div>
                </div>
                {{ csrf_field() }}
                <label for="text">User name</label>

                <div class="field" style="padding-bottom: 24px" autofocus>
                    <form method="POST" action="/projectsSearch" enctype="multipart/form-data" class="input-group rounded">
                        {{@csrf_field()}}
                        <input type="search" name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="input-group-text border-0" id="search-addon">
                            <i class="icon-magnifier"></i>
                        </button>
                    </form>
                </div>
                @if ($errors->has('report_type'))
                <span class="error">
                    {{ $errors->first('report_type') }}
                </span>
                @endif
                <div class="field" style="padding-bottom: 24px">
                    <input type="submit" name="submit" value="Report">
                </div>
            </form>
        </div>
    </div>
    @endsection