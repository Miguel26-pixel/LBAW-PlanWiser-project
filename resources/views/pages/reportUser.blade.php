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
                <span style="padding-bottom: 15px">Make a report</span>
                <form id="stripe-login" method="POST" action='/reportUser/{{$reported->id}}'>
                    {{ csrf_field() }}
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

                    <label for="text">Username</label>
                    <div class="field border-danger" style="padding:5px; margin-bottom: 24px; border: 2px solid; border-radius: 5px" autofocus>
                        {{$reported->username}}
                    </div>
                    @if ($errors->has('report_type'))
                        <div class="field">
                        <span class="error">
                        {{ $errors->first('report_type') }}
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

