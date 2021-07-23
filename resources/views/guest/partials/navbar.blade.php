    <div class="header__top d-none d-lg-block">
      <div class="container">
        <div class="logo"><a href="{{ route('home') }}"><img class="img-fluid"
              src="{{ asset('assets/guest/img/logo.png') }}" alt="Logo"></a>
        </div>
      </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">

        <a href="{{ route('home') }}" class="navbar-brand d-lg-none">
          <div class="logo">
            <img class="w-auto h-100" src="{{ asset('assets/guest/img/logo.png') }}" alt="Logo">
          </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav m-lg-auto">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                href="{{ route('home') }}">Beranda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('guest.bps.index') | request()->is('guest/bps/*') ? 'active' : '' }}"
                href="{{ route('guest.bps.index') }}">BPS</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('guest.rpjmd.index') || request()->is('guest/rpjmd/*') ? 'active' : '' }}"
                href="{{ route('guest.rpjmd.index') }}">RPJMD</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('guest.delapankeldata.index') || request()->is('guest/delapankeldata/*') ? 'active' : '' }}"
                href="{{ route('guest.delapankeldata.index') }}">8 Kelompok Data</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('guest.skpd') ? 'active' : '' }}"
                href="{{ route('guest.skpd') }}">SKPD</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('guest.indikator.index') || request()->is('guest/indikator/*') ? 'active' : '' }}"
                href="{{ route('guest.indikator.index') }}">Indikator Kerja</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://tawk.to/pusdasitubondo" target="_blank" rel=noreferrer>Live Chat</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
