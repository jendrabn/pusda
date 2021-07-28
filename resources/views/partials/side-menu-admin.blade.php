<li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
    <span>Dashboard</span></a>
</li>
<li class="menu-header">Data Utama</li>
<li class="dropdown {{ request()->is('admin/delapankeldata/*') ? 'active' : '' }}">
  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-book"></i>
    <span>8 Kelompok Data</span></a>
  <ul class="dropdown-menu">
    @foreach (\App\Models\SkpdCategory::all() as $skpd_category)
      <li class="{{ request()->path() === 'admin/delapankeldata/' . $skpd_category->name ? 'active' : '' }}">
        <a class="nav-link"
          href="{{ route('admin.delapankeldata.index', [$skpd_category->name]) }}">{{ $skpd_category->name }}</a>
      </li>
    @endforeach
    <li class=""><a class="nav-link" href="{{ route('admin.delapankeldata.index') }}">8 Kel. Data</a></li>
  </ul>
</li>

<li class="dropdown {{ request()->is('admin/rpjmd/category/*') ? 'active' : '' }}">
  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-briefcase"></i>
    <span>RPJMD</span></a>
  <ul class="dropdown-menu">
    @foreach (\App\Models\SkpdCategory::all() as $skpd_category)
      <li class="{{ request()->path() === 'admin/rpjmd/category/' . $skpd_category->name ? 'active' : '' }}">
        <a class="nav-link"
          href="{{ route('admin.rpjmd.category', [$skpd_category->name]) }}">{{ $skpd_category->name }}</a>
      </li>
    @endforeach
    <li class=""><a class="nav-link" href="{{ route('admin.rpjmd.index') }}">RPJMD</a></li>
  </ul>
</li>

<li class="{{ request()->is('admin/indikator/*') || request()->routeIs('admin.indikator.index') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('admin.indikator.index') }}"><i class="fas fa-layer-group"></i>
    <span>Indikator</span></a>
</li>
<li class="">
  <a class="nav-link" href="{{ route('admin.bps.index') }}"><i class="fas fa-th-large"></i>
    <span>BPS</span></a>
</li>
<li
  class="dropdown {{ request()->is('admin/treeview/delapankeldata/*') || request()->routeIs('admin.treeview.delapankeldata.index') || request()->is('admin/treeview/rpjmd/*') || request()->routeIs('admin.treeview.rpjmd.index') || request()->is('admin/treeview/indikator/*') || request()->routeIs('admin.treeview.indikator.index') || request()->is('admin/treeview/bps/*') || request()->routeIs('admin.treeview.bps.index') || request()->is('admin/uraian/delapankeldata/*') || request()->routeIs('admin.uraian.delapankeldata.index') || request()->is('admin/uraian/rpjmd/*') || request()->routeIs('admin.uraian.rpjmd.index') || request()->is('admin/uraian/indikator/*') || request()->routeIs('admin.uraian.indikator.index') || request()->is('admin/uraian/bps/*') || request()->routeIs('admin.uraian.bps.index') ? 'active' : '' }}">
  <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-table"></i>
    <span>Master Tabel</span></a>
  <ul class="dropdown-menu">
    <li
      class="{{ request()->is('admin/treeview/delapankeldata/*') || request()->routeIs('admin.treeview.delapankeldata.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.treeview.delapankeldata.index') }}">Menu 8 Kel. Data</a>
    </li>
    <li
      class="{{ request()->is('admin/treeview/rpjmd/*') || request()->routeIs('admin.treeview.rpjmd.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.treeview.rpjmd.index') }}">Menu
        RPJMD</a>
    </li>
    <li
      class="{{ request()->is('admin/treeview/indikator/*') || request()->routeIs('admin.treeview.indikator.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.treeview.indikator.index') }}">Menu
        Indikator</a>
    </li>
    <li
      class="{{ request()->is('admin/treeview/bps/*') || request()->routeIs('admin.treeview.bps.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.treeview.bps.index') }}">Menu
        BPS</a>
    </li>
    <li
      class="{{ request()->is('admin/uraian/delapankeldata/*') || request()->routeIs('admin.uraian.delapankeldata.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.uraian.delapankeldata.index') }}">Form 8 Kel. Data</a>
    </li>
    <li
      class="{{ request()->is('admin/uraian/rpjmd/*') || request()->routeIs('admin.uraian.rpjmd.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.uraian.rpjmd.index') }}">Form RPJMD</a>
    </li>
    <li
      class="{{ request()->is('admin/uraian/indikator/*') || request()->routeIs('admin.uraian.indikator.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.uraian.indikator.index') }}">Form Indikator</a>
    </li>
    <li
      class="{{ request()->is('admin/uraian/bps/*') || request()->routeIs('admin.uraian.bps.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.uraian.bps.index') }}">Form BPS</a>
    </li>
  </ul>
</li>
<li class="menu-header">Menu</li>
<li class="{{ request()->routeIs('admin.users.index') || request()->is('admin/users/*') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i>
    <span>User</span></a>
</li>
<li class="{{ request()->routeIs('admin.userlog.index') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('admin.userlog.index') }}"><i class="fas fa-user-clock"></i>
    <span>Log User</span></a>
</li>
<li class="{{ request()->routeIs('admin.visitor') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('admin.visitor') }}"><i class="fas fa-eye"></i>
    <span>Pengunjung</span></a>
</li>
<li class="{{ request()->routeIs('admin.skpd.index') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('admin.skpd.index') }}"><i class="fas fa-briefcase"></i>
    <span>SKPD</span></a>
</li>
<li class="{{ request()->routeIs('admin.print_reports') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('admin.print_reports') }}"><i class="fas fa-print"></i>
    <span>Cetak Laporan</span></a>
</li>
