<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  @extends('layouts.head')
  <body>
    <main>
      <header>
        <h1><a href="{{ url('/dashboard') }}">Thingy!</a></h1>
        @if (Auth::check())
        <a class="button" href="{{ url('/logout') }}"> Logout </a> <span>{{ Auth::user()->name }}</span>
        @endif
      </header>
      <section id="content">
        @yield('content')
      </section>
    </main>
  </body>
</html>
