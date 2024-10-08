<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a class="brand-link text-center"
       href="#">
        <span class="brand-text font-weight-bold"
              style="letter-spacing: .5rem;">PUSDA</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-accordion="false"
                data-widget="treeview"
                role="menu">

                @role(\App\Models\User::ROLE_ADMIN)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-tachometer-alt nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/bps*') ? 'active' : '' }}"
                           href="{{ route('admin.bps.index') }}">
                            <i class="fa-solid fa-th-large nav-icon"></i>
                            <p>BPS</p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->is('admin/rpjmd*') ? 'menu-open' : '' }}">
                        <a class="nav-link {{ request()->is('admin/rpjmd*') ? 'active' : '' }}"
                           href="#">
                            <i class="nav-icon fa-solid fa-briefcase"></i>
                            <p>
                                RPJMD
                                <i class="fa-solid fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach (\App\Models\KategoriSkpd::pluck('nama', 'id') as $id => $nama)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/rpjmd/kategori' . $id) ? 'active' : '' }}"
                                       href="{{ route('admin.rpjmd.category', $id) }}">
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
                            <i class="nav-icon fa-solid fa-book"></i>
                            <p>
                                8 Kel. Data
                                <i class="fa-solid fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @foreach (\App\Models\KategoriSkpd::pluck('nama', 'id') as $id => $nama)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('admin/delapankeldata/kategori/' . $id) ? 'active' : '' }}"
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
                            <i class="fa-solid fa-layer-group nav-icon"></i>
                            <p>Indikator</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">
                            <i class="fa-solid fa-users nav-icon"></i>
                            <p>Users</p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->is('admin/treeview*') || request()->is('admin/uraian*') ? 'menu-open' : '' }}">
                        <a class="nav-link {{ request()->is('admin/treeview*') || request()->is('admin/uraian*') ? 'active' : '' }}"
                           href="#">
                            <i class="nav-icon fa-solid fa-table"></i>
                            <p>
                                Master Tabel
                                <i class="fa-solid fa-angle-left right"></i>
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
                            <i class="fa-solid fa-briefcase nav-icon"></i>
                            <p>SKPD</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}"
                           href="{{ route('admin.audit-logs.index') }}">
                            <i class="nav-icon fa-solid fa-file-alt">
                            </i>
                            <p>
                                Audit Logs
                            </p>
                        </a>
                    </li>
                @endrole

                @role(\App\Models\User::ROLE_SKPD)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-tachometer-alt nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.delapankeldata.*') ? 'active' : '' }}"
                           href="{{ route('admin.delapankeldata.index') }}">
                            <i class="fa-solid fa-book nav-icon"></i>
                            <p>8 Kel. Data</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.rpjmd.*') ? 'active' : '' }}"
                           href="{{ route('admin.rpjmd.index') }}">
                            <i class="fa-solid fa-briefcase nav-icon"></i>
                            <p>RPJMD</p>
                        </a>
                    </li>
                @endrole

            </ul>
        </nav>
    </div>
</aside>
