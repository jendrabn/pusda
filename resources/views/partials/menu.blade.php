<nav>
    <ul class="nav nav-pills nav-sidebar flex-column"
        data-accordion="false"
        data-widget="treeview"
        role="menu">

        @role(\App\Models\User::ROLE_ADMIN)
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/bps*') ? 'active' : '' }}"
                   href="{{ route('admin.bps.index') }}">
                    <i class="fas fa-th-large nav-icon"></i>
                    <p>BPS</p>
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/rpjmd*') ? 'menu-open' : '' }}">
                <a class="nav-link {{ request()->is('admin/rpjmd*') ? 'active' : '' }}"
                   href="#">
                    <i class="nav-icon fas fa-briefcase"></i>
                    <p>
                        RPJMD
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (\App\Models\KategoriSkpd::pluck('nama', 'id') as $id => $nama)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/rpjmd/' . $id) ? 'active' : '' }}"
                               href="{{ route('admin.rpjmd.index', $id) }}">
                                <i class="far fa-folder nav-icon"></i>
                                <p>{{ $nama }}</p>
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/rpjmd') ? 'active' : '' }}"
                           href="{{ route('admin.rpjmd.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>RPJMD</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ request()->is('admin/delapankeldata*') ? 'menu-open' : '' }}">
                <a class="nav-link {{ request()->is('admin/delapankeldata*') ? 'active' : '' }}"
                   href="#">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        8 Kel. Data
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @foreach (\App\Models\KategoriSkpd::pluck('nama', 'id') as $id => $nama)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/delapankeldata/category/' . $id) ? 'active' : '' }}"
                               href="{{ route('admin.delapankeldata.category', $id) }}">
                                <i class="far fa-folder nav-icon"></i>
                                <p>{{ $nama }}</p>
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/delapankeldata') ? 'active' : '' }}"
                           href="{{ route('admin.delapankeldata.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>8 Kel. Data</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/indikator*') ? 'active' : '' }}"
                   href="{{ route('admin.indikator.index') }}">
                    <i class="fas fa-layer-group nav-icon"></i>
                    <p>Indikator</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users nav-icon"></i>
                    <p>Users</p>
                </a>
            </li>

            <li
                class="nav-item {{ request()->is('admin/treeview*') || request()->is('admin/uraian*') ? 'menu-open' : '' }}">
                <a class="nav-link {{ request()->is('admin/treeview*') || request()->is('admin/uraian*') ? 'active' : '' }}"
                   href="#">
                    <i class="nav-icon fas fa-table"></i>
                    <p>
                        Master Tabel
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/treeview/delapankeldata*') ? 'active' : '' }}"
                           href="{{ route('admin.treeview.delapankeldata.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>Menu 8 Kel. Data</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/treeview/rpjmd*') ? 'active' : '' }}"
                           href="{{ route('admin.treeview.rpjmd.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>Menu RPJMD</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/treeview/indikator*') ? 'active' : '' }}"
                           href="{{ route('admin.treeview.indikator.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>Menu Indikator</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/treeview/bps*') ? 'active' : '' }}"
                           href="{{ route('admin.treeview.bps.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>Menu BPS</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/uraian/delapankeldata*') ? 'active' : '' }}"
                           href="{{ route('admin.uraian.delapankeldata.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>Form 8 Kel. Data</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/uraian/rpjmd*') ? 'active' : '' }}"
                           href="{{ route('admin.uraian.rpjmd.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>Form RPJMD</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/uraian/indikator*') ? 'active' : '' }}"
                           href="{{ route('admin.uraian.indikator.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>Form Indikator</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/uraian/bps*') ? 'active' : '' }}"
                           href="{{ route('admin.uraian.bps.index') }}">
                            <i class="far fa-folder nav-icon"></i>
                            <p>Form BPS</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.skpd.*') ? 'active' : '' }}"
                   href="{{ route('admin.skpd.index') }}">
                    <i class="fas fa-briefcase nav-icon"></i>
                    <p>SKPD</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/audit-logs*') ? 'active' : '' }}"
                   href="{{ route('admin.audit-logs.index') }}">
                    <i class="nav-icon fas fa-file-alt">
                    </i>
                    <p>
                        Audit Logs
                    </p>
                </a>
            </li>
        @endrole

        @role(\App\Models\User::ROLE_SKPD)
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin-skpd/dashboard') ? 'active' : '' }}"
                   href="{{ route('admin_skpd.dashboard') }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin-skpd/delapankeldata*') ? 'active' : '' }}"
                   href="{{ route('admin_skpd.delapankeldata.index') }}">
                    <i class="fas fa-book nav-icon"></i>
                    <p>8 Kel. Data</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin-skpd/rpjmd*') ? 'active' : '' }}"
                   href="{{ route('admin_skpd.rpjmd.index') }}">
                    <i class="fas fa-briefcase nav-icon"></i>
                    <p>RPJMD</p>
                </a>
            </li>
        @endrole

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
               href="{{ route('profile') }}">
                <i class="fas fa-user nav-icon"></i>
                <p>Profil</p>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link"
               href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <p>Logout</p>
                <form action="{{ route('auth.logout') }}"
                      class="d-none"
                      id="logout-form"
                      method="POST">
                    @csrf
                </form>
            </a>
        </li>

    </ul>
</nav>
