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
          rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          rel="stylesheet" />
    @vite('resources/scss/adminlte/adminlte.scss')
    @yield('styles')
</head>

<body class="hold-transition login-page">

    <div class="login-box">
        {{-- <div class="login-logo">
            <a href="{{ route('home') }}"><b>PUSDA</b></a>
        </div> --}}
        <div class="card">
            <div class="card-body login-card-body">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    @yield('scripts')
</body>

</html>
