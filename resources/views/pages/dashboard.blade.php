@extends('layouts.app')

@section('title', 'Dashboard')

@section('topnavbar')
    <?php if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->is_admin) {?>
        @include('partials.adminnavbar')
    <?php } else { ?>
        @include('partials.navbar')
    <?php } ?>
@endsection

@section('content')

@endsection
