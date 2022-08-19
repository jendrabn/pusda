@php
$skpdCategories = \App\Models\SkpdCategory::pluck('name', 'id');
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <span class="brand-text font-weight-light">
      <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid">
    </span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ auth()->user()->avatar_url }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <p>Dashboard</p>
          </a>
        </li>

        @if (auth()->user()->role == 1)
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                8 Kel. Data
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @foreach ($skpdCategories as $id => $name)
                <li class="nav-item">
                  <a href="{{ route('admin.delapankeldata.index', $id) }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ $name }}</p>
                  </a>
                </li>
              @endforeach
              <li class="nav-item">
                <a href="{{ route('admin.delapankeldata.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>8 Kel. Data</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>
                RPJMD
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @foreach ($skpdCategories as $id => $name)
                <li class="nav-item">
                  <a href="{{ route('admin.rpjmd.index', $id) }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ $name }}</p>
                  </a>
                </li>
              @endforeach
              <li class="nav-item">
                <a href="{{ route('admin.rpjmd.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>RPJMD</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.bps.index') }}"
              class="nav-link {{ request()->routeIs('admin.bps.*') ? 'active' : '' }}">
              <i class="fas fa-th-large nav-icon"></i>
              <p>BPS</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Master Tabel
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.treeview.delapankeldata.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu 8 Kel. Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.treeview.rpjmd.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu RPJMD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.treeview.indikator.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu Indikator</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.treeview.bps.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Menu BPS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.uraian.delapankeldata.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Form 8 Kel. Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.uraian.rpjmd.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Form RPJMD</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.uraian.indikator.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Form Indikator</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.uraian.bps.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Form BPS</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.users.index') }}"
              class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
              <i class="fas fa-users nav-icon"></i>
              <p>Users</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.skpd.index') }}"
              class="nav-link {{ request()->routeIs('admin.skpd.*') ? 'active' : '' }}">
              <i class="fas fa-briefcase nav-icon"></i>
              <p>SKPD</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{ route('admin.audit-logs.index') }}"
              class="nav-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt">

              </i>
              <p>
                Audit Logs
              </p>
            </a>
          </li>
        @endif

        @if (auth()->user()->role == 2)
          <li class="nav-item">
            <a href="{{ route('skpd.delapankeldata.index') }}"
              class="nav-link {{ request()->routeIs('skpd.delapankeldata.*') ? 'active' : '' }}">
              <i class="fas fa-book nav-icon"></i>
              <p>8 Kel. Data</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('skpd.rpjmd.index') }}"
              class="nav-link {{ request()->routeIs('skpd.rpjmd.*') ? 'active' : '' }}">
              <i class="fas fa-briefcase nav-icon"></i>
              <p>RPJMD</p>
            </a>
          </li>
        @endif

        <li class="nav-header">AKUN</li>
        <li class="nav-item">
          <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="fas fa-user nav-icon"></i>
            <p>Profil</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('changePassword') }}"
            class="nav-link {{ request()->routeIs('changePassword') ? 'active' : '' }}">
            <i class="fas fa-key nav-icon"></i>
            <p>Ubah Password</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link"
            onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
            <p>
              <i class="fas fa-sign-out-alt nav-icon">
              </i>
              <p>Logout</p>
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
