<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="p-0">
  @include('layouts.head')
  <body>
  @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
    <main>
      <header>
        @include('partials.navbar')
      </header>
      <section id="content">
        @yield('content')
        @yield('homepage')
      </section>
    </main>
  </body>
  @yield('scripts')
</html>
