<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1"
          name="viewport">
    <meta content="{{ csrf_token() }}"
          name="csrf-token">

    <title>{{ isset($title) ? $title : 'Home' }} | {{ config('app.name') }} </title>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
          rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css"
          rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs4-4.6.0/jszip-3.10.1/dt-2.1.0/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/r-3.0.2/sl-2.0.3/datatables.min.css"
          rel="stylesheet">
    @vite('resources/scss/adminlte/adminlte.scss')
    @yield('styles')
</head>

<body class="hold-transition login-page">
    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
            src="https://cdn.datatables.net/v/bs4-4.6.0/jszip-3.10.1/dt-2.1.0/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/r-3.0.2/sl-2.0.3/datatables.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    @yield('scripts')
</body>

</html>
