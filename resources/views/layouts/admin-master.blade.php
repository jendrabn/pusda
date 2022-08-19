<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="...">
  <meta name="keywords" content="...">
  <meta name="author" content="...">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="Pusat Data Kabupaten Situbondo">
  <meta name="theme-color" content="#445566">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/icons/logo-situbondo.png') }}">
  <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="{{ asset('assets/icons/logo-situbondo.png') }}">
  <title>@yield('title', 'Home') &mdash; Pusat Data Kabupaten Situbondo</title>
  <link rel="stylesheet" href="{{ asset('assets/module/jstree/dist/themes/default/style.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <style>
    #dataTable_length select {
      min-width: 65px;
    }
  </style>
  @stack('styles')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        @include('partials.topbar')
      </nav>
      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          @include('partials.sidebar')
        </aside>
      </div>
      <div class="main-content">
        <section class="section">
          @yield('content')
        </section>
      </div>
      <footer class="main-footer">
        @include('partials.footer')
      </footer>
    </div>
  </div>

  <div class="scroll-top">
    <button class="btn btn-dark" type="button" aria-label="Scroll to top">
      <i class="fas fa-arrow-up"></i>
    </button>
  </div>

  @yield('outer')
  <script src="{{ asset('assets/js/app.js') }}"></script>
  <script src="{{ asset('assets/module/jstree/dist/jstree.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"
    integrity="sha256-qoN08nWXsFH+S9CtIq99e5yzYHioRHtNB9t2qy1MSmc=" crossorigin="anonymous"></script>
  <script>
    $(function() {
      $('#dataTable').DataTable({
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json'
        }
      });

      $('.select2').select2();
    });
  </script>
  @stack('scripts')
</body>

</html>
