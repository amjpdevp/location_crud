<html>
    <head>
        @include('includes.head')
    </head>
  <body>
    @unless(isset($noNav))
    @include('includes.navbar')
    <div class="d-flex h-100">
    @include('includes.sidebar')
    @endunless
    <div class="p-3">
        @yield('content')
    </div>
    <div>
      @include('includes.script')
  </body>
</html>