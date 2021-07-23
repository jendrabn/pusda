<li class="{{ request()->routeIs('skpd.dashboard') ? 'active' : '' }}">
  <a class="nav-link" href="{{ route('skpd.dashboard') }}"><i class="fas fa-fire"></i>
    <span>Dashboard</span></a>
</li>
<li class="">
  <a class="nav-link" href="{{ route('skpd.delapankeldata.index') }}"><i class="fas fa-book"></i>
    <span>8 Kelompok Data</span></a>
</li>
<li class="">
  <a class="nav-link" href="{{ route('skpd.rpjmd.index') }}"><i class="fas fa-briefcase"></i>
    <span>RPJMD</span></a>
</li>
