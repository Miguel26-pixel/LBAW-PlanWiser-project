@extends('layouts.app')

@section('title', 'Invite')

@section('topnavbar')
    <?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) {?>
    @include('partials.adminnavbar')
    <?php } else { ?>
    @include('partials.navbar', ['notifications' => $notifications])
    <?php } ?>
@endsection

@section('content')
<div class="formbg-outer">
  <div class="formbg">
    <div class="formbg-inner" style="padding: 48px">
      <span style="padding-bottom: 15px">Add Member</span>
      <form action="/project/{{$project->id}}/members/invitation" method="POST">
        @csrf
        <div class="field" style="padding-bottom: 24px">
          <label for="username">Username</label>
          <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
        </div>
        @if ($errors->has('username'))
        <span class="error">
          {{ $errors->first('username') }}
        </span>
        @endif
        <div class="field" style="padding-bottom: 24px">
          <label for="user_role">Role</label>
          <select name="user_role" class="form-select" required>
              <option value='GUEST'>GUEST</option>
              <option value='MEMBER'>MEMBER</option>
              <option value='MEMBER'>MANAGER</option>
          </select>
        </div>
        @if ($errors->has('user_role'))
        <span class="error">
          {{ $errors->first('user_role') }}
        </span>
        @endif

        <div class="field" style="padding-bottom: 24px">
          <input type="submit" name="submit" value="Send Invite">
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

