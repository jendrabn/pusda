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
  <link rel="stylesheet" href="{{ asset('assets/module/DataTables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

  <style>
    #dataTable_length select {
      min-width: 65px;
    }

    .table td {
      padding: 3px 5px;
      height: 50px;
      vertical-align: middle;
      color: #333333;
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

  @yield('outer')
  <script src="{{ asset('assets/js/app.js') }}"></script>
  <script src="{{ asset('assets/module/jstree/dist/jstree.min.js') }}"></script>
  <script src="{{ asset('assets/module/DataTables/datatables.min.js') }}"></script>
  <script>
    $(function() {
      $('#dataTable').DataTable({
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ]
      });

      $('.select2').select2();
    });
  </script>
  @stack('scripts')
</body>

</html>
