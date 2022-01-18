@extends('layouts.errors')

@section('errors')
<div class="error-body">
    <div class="error-message">Page not found.</div>
    <div class="error-message2">You tried to access a page that doesn't exist.</div>
    <div class="error-container">
        <div class="error-neon">404</div> 
    </div>
</div>
@endsection