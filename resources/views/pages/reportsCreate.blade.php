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
                <div class="field" style="padding-bottom: 24px">
                    <label for="report_type">Report Type</label>
                    <select name="report_type" class="form-select" aria-label="Disabled select example" required>
                        <option value='USER'>User</option>
                        <option value='BUG'>Bug</option>
                    </select>
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
