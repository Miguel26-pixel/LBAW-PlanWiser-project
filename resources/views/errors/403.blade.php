@extends('layouts.errors')

@section('errors')
<div class="error-body">
    <div class="error-container">
        <div class="error-neon">403</div> 
    </div>
    <div class="error-message">You are not authorized.</div>
    <div class="error-message2">You tried to access a page you did not have prior authorization for.</div>
</div>
@endsection