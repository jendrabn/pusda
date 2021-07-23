 <li
   class="nav-item {{ request()->routeIs('skpd.delapankeldata.index') || request()->is('skpd/delapankeldata/*') ? 'active' : '' }}">
   <a href="{{ route('skpd.delapankeldata.index') }}" class="nav-link"><i class="fas fa-book"></i><span>8 Kelompok
       Data</span></a>
 </li>
 <li
   class="nav-item {{ request()->routeIs('skpd.rpjmd.index') || request()->is('skpd/rpjmd/*') ? 'active' : '' }}">
   <a href="{{ route('skpd.rpjmd.index') }}" class="nav-link"><i class="fas fa-briefcase"></i><span>RPJMD</span></a>
 </li>
