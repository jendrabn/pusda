<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description"
    content="Pusat Data Kabupaten Situbondo yang dibangun sebegai pusat data dan informasi pembangunan, serta media keterbukaan publik tentang informasi Kabupaten Situbondo">
  <meta name="keywords" content="Pusda, Situbondo, Kominfo, BPS, RPJMD, 8 Kelompok Data, Indikator">
  <meta name="author" content="Jendra Bayu Nugraha">
  <meta name="robots" content="noindex, follow">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="Pusat Data Kabupaten Situbondo">
  <meta name="theme-color" content="#445566">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/icons/logo-situbondo.png') }}">
  <link rel="apple-touch-icon" type="image/png" sizes="192x192" href="{{ asset('assets/icons/logo-situbondo.png') }}">
  <title>@yield('title', 'Home') &mdash; Pusat Data Kabupaten Situbondo</title>
  @include('guest.partials.styles')
  @stack('styles')
</head>

<body>
  <header>
    @include('guest.partials.navbar')
  </header>

  <main>
    @yield('content')
  </main>

  <div class="scroll-top">
    <button class="btn btn-dark" type="button" aria-label="Scroll to top">
      <i class="fas fa-arrow-up"></i>
    </button>
  </div>

  @include('guest.partials.footer')
  @include('guest.partials.scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js@3.4.0/dist/chart.min.js"
    integrity="sha256-sKuIOg+m9ZQb96MRaiHCMzLniSnMlTv1h1h4T74C8ls=" crossorigin="anonymous"></script>
  @stack('scripts')
</body>

</html>
