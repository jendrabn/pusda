<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="IE=edge"
          http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1.0"
          name="viewport">
    <title>{{ $title ?? 'Home' }} &mdash; Pusat Data Kabupaten Situbondo</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
          rel="stylesheet" />
    <link href="https://fonts.googleapis.com"
          rel="preconnect">
    <link crossorigin
          href="https://fonts.gstatic.com"
          rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap"
          rel="stylesheet">

    @vite(['resources/scss/front/style.scss'])

    @yield('styles')
    @stack('styles')
</head>

<body>
    <header>
        <div class="header__top d-none d-lg-block">
            <div class="container">
                <div class="logo"><a href="{{ route('home') }}"><img alt="Logo"
                             class="img-fluid"
                             src="{{ asset('img/logo.png') }}"></a>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand d-lg-none"
                   href="{{ route('home') }}">
                    <div class="logo">
                        <img alt="Logo"
                             class="h-100 w-auto"
                             src="{{ asset('img/logo.png') }}">
                    </div>
                </a>

                <button aria-controls="navbarNav"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                        class="navbar-toggler"
                        data-bs-target="#navbarNav"
                        data-bs-toggle="collapse"
                        type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse"
                     id="navbarNav">
                    <ul class="navbar-nav m-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                               href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('bps.index') | request()->is('guest/bps/*') ? 'active' : '' }}"
                               href="{{ route('bps.index') }}">BPS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('rpjmd.index') || request()->is('guest/rpjmd/*') ? 'active' : '' }}"
                               href="{{ route('rpjmd.index') }}">RPJMD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('delapankeldata.index') || request()->is('guest/delapankeldata/*') ? 'active' : '' }}"
                               href="{{ route('delapankeldata.index') }}">8 Kelompok Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('skpd') ? 'active' : '' }}"
                               href="{{ route('skpd') }}">SKPD</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('indikator.index') || request()->is('guest/indikator/*') ? 'active' : '' }}"
                               href="{{ route('indikator.index') }}">Indikator Kerja</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="#">Data Statistik Sektoral</a>
                        </li>

                        <li class="nav-item">
                            @if (auth()->check())
                                <a class="nav-link"
                                   href="{{ route('admin.dashboard') }}"
                                   target="_blank">Dashboard</a>
                            @else
                                <a class="nav-link"
                                   href="{{ route('auth.login') }}"
                                   target="_blank">Login</a>
                            @endif
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="https://tawk.to/pusdasitubondo"
                               rel=noreferrer
                               target="_blank">Live Chat</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <div class="scroll-top">
        <button aria-label="Scroll to top"
                class="btn btn-dark"
                type="button">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
    </div>

    <footer>
        <div class="footer__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 footer__item">
                        <h5>Pengembang</h5>
                        <ul>
                            <li> <a href="mailto:jendra455@gmail.com">Jendra Bayu Nugraha</a> <a
                                   class="text-decoration-none"
                                   href="https://ilkom.unej.ac.id"
                                   rel=noreferrer
                                   target="_blank">Fakultas Ilmu Komputer
                                    Universitas Jember</a></li>
                            <li><a class="logo"
                                   href="https://unej.ac.id/id"
                                   rel=noreferrer
                                   target="_blank"><img alt="Logo Universitas Jember"
                                         class="img-fluid"
                                         src="{{ asset('img/logo-unej.png') }}"></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4 footer__item">
                        <h5>Alamat</h5>
                        <ul>
                            <li>Pemerintah Kabupaten Situbondo <br>
                                Jln. P.B. Sudirman No.1 Kabupaten Situbondo 68312, Provinsi Jawa Timur
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-4 footer__item">
                        <h5>Kontak Kami</h5>
                        <ul>
                            <li>Telp : [0338] 674096, 671161 / [0338] 674222 ext 236</li>
                            <li>Fax. : [0338] 674096, 671885</li>
                            <li>Email: <a href="mailto:admin@situbondokab.go.id">admin@situbondokab.go.id</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="container"><span>2021 © PUSDA Situbondo</span> | <a href="http://kominfo.situbondokab.go.id"
                   rel=noreferrer
                   target="_blank">Dinas Kominfo dan
                    Persandian Pemkab Situbondo</a></div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        const scrollTopElm = document.querySelector('.scroll-top');

        scrollTopElm.addEventListener('click', function() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0; // for safari
        });

        window.addEventListener('scroll', function() {
            if (pageYOffset > document.getElementsByTagName('header')[0].clientHeight) {
                scrollTopElm.classList.add('show');
            } else {
                scrollTopElm.classList.remove('show');
            }
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>

</html>
