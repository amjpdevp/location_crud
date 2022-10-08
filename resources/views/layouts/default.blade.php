<!doctype html>
<html>
<head>
   @include('includes.head')
</head>
<body>
   @unless(isset($noNav))
    @include('includes.navbar') 
    @include('includes.sidebar')
   @endunless
   
   <div id="page-content-wrapper" class="row p-3">
         @yield('content')
   </div>
   </section>
@include('includes.script')
</body>
</html>