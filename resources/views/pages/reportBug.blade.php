@extends('layouts.app')

@section('title', 'Reports')

@section('topnavbar')
    <?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) {?>
    @include('partials.adminnavbar')
    <?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
    <?php } ?>
@endsection

@section('content')
    <div class="formbg-outer pt-5">
        <div class="formbg">
            <div class="formbg-inner" style="padding: 48px">
                <span style="padding-bottom: 15px">Bug Report</span>
                <form id="stripe-login" method="POST" action='/reportBug'>
                    {{ csrf_field() }}
                    <div class="field" style="padding-bottom: 24px">
                        <label for="text">Report's description</label>
                        <textarea rows="5" class="col-md-12" name="text" required></textarea>
                    </div>
                    @if ($errors->has('text'))
                        <div class="field">
                            <span class="error">
                            {{ $errors->first('text') }}
                            </span>
                        </div>
                    @endif

                    <div class="field" id="btn" style="padding-bottom: 24px;">
                        <input type="submit" name="submit" value="Report">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

