<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="p-0">
@include('layouts.head')

<body>
    <main>
        <header>
            @yield('topnavbar')
        </header>
        <div style="margin-top: 107px">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @yield('content')
        </div>
    </main>
</body>
@yield('scripts')
@yield('scripts_nav')

</html>
