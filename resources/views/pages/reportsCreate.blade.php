@extends('layouts.app')

@section('title', 'Reports')

@section('topnavbar')
@include('partials.navbar', ['notifications' => $notifications])
@endsection

@section('content')

<div class="formbg-outer pt-5">
    <div class="formbg">
        <div class="formbg-inner" style="padding: 48px">
            <span style="padding-bottom: 15px">Make a report</span>
            <form id="stripe-login" method="POST" action='/reportsCreate'>
                {{ csrf_field() }}
                <div style="padding-bottom: 24px">
                    <label for="report_type">Report Type</label>
                    <div class="d-flex flex-direction-row align-items-center gap-5">
                        <div class="d-flex gap-2">
                            <input type="radio" id="user_radio" name="radio" value="USER">
                            <label class="pt-2" for="user_radio">User</label><br>
                        </div>
                        <div class="d-flex gap-2">
                            <input type="radio" id="bug_radio" name="radio" value="BUG">
                            <label class="pt-2" for="bug_radio">Bug</label><br>
                        </div>
                    </div>
                </div>
                <div id="description" style="display: none">
                    <div class="field" style="padding-bottom: 24px"  autofocus>
                        <label for="text">Report's description</label>
                        <textarea rows="5" class="col-md-12" type=" text" name="text" required></textarea>
                    </div>
                    @if ($errors->has('text'))
                        <div class="field">
                    <span class="error">
                        {{ $errors->first('text') }}
                    </span>
                        </div>
                    @endif
                </div>

                <div id="user" style="display: none">
                    <label for="text">User name</label>
                    <div class="field" style="padding-bottom: 24px" autofocus>
                        <input type="text" name="username" id="username" class="form-control rounded" placeholder="Username" aria-label="Username" aria-describedby="search-addon"/>
                    </div>
                    @if ($errors->has('report_type'))
                        <span class="error">
                    {{ $errors->first('report_type') }}
                </span>
                    @endif
                </div>
                <div class="field" id="btn" style="padding-bottom: 24px; display: none">
                    <input type="submit" name="submit" value="Report">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        const user = document.getElementById('user_radio');
        if (user.checked) {userReport();}
        user.addEventListener("change", userReport);
        function userReport() {
            document.getElementById('description').style.display = 'block';
            document.getElementById('user').style.display = 'block';
            document.getElementById('btn').style.display = 'block';
            document.getElementById('username').required = true;
        }

        const bug = document.getElementById('bug_radio');
        if (bug.checked) {bugReport();}
        bug.addEventListener("change", bugReport);
        function bugReport() {
            document.getElementById('description').style.display = 'block';
            document.getElementById('user').style.display = 'none';
            document.getElementById('btn').style.display = 'block';
            document.getElementById('username').required = false;
        }
    </script>
@endsection


