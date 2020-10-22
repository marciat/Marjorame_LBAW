<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="generator" content="Jekyll v3.8.6">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="{{ asset('MDBootstrap/css/bootstrap.min.css') }}">
  <!-- Material Design Bootstrap -->
  <link rel="stylesheet" href="{{ asset('MDBootstrap/css/mdb.min.css') }}">


  <link href="{{ asset('css/flag.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/flags.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <script src="https://kit.fontawesome.com/7f7ec37f07.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/app.js') }}" defer> </script>


  <!-- jQuery -->
  <script src="{{ asset('MDBootstrap/js/jquery.min.js')}}"></script>
  <!-- Bootstrap tooltips -->
  <script src="{{ asset('MDBootstrap/js/popper.min.js')}}"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="{{ asset('MDBootstrap/js/bootstrap.min.js')}}"></script>
  <!-- MDB core JavaScript -->
  <script src="{{ asset('MDBootstrap/js/mdb.min.js')}}"></script>

  <script src="{{ asset('js/purchase_history.js') }}" defer></script>
  <script src="{{ asset('js/showmore.js') }}" defer></script>
  <script src="{{ asset('js/review_dropdown.js') }}" defer></script>
  <script src="{{ asset('js/list_of_items.js') }}" defer></script>
  <script src="{{ asset('js/product_images.js') }}" defer></script>
  <script src="{{ asset('js/add_product.js') }}" defer></script>

  <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Serif&display=swap" rel="stylesheet">

</head>

<body>
  <main role="main">
    <header>
      @include('partials.navbar')
    </header>

    <div class="page-wrapper">
      <section id="content">
        @yield('content')
      </section>
    </div>
  </main>

  <footer class="page-footer font-small bar_background pt-4">
    @include('partials.footer')
  </footer>
</body>

</html>