 <li
   class="nav-item dropdown {{ request()->is('admin/delapankeldata/*') || request()->routeIs('admin.delapankeldata.index') ? 'active' : '' }}">
   <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>8 Kel.
       Data</span></a>
   <ul class="dropdown-menu">
     @foreach (\App\Models\SkpdCategory::all() as $skpd_category)
       <li class="nav-item"><a class="nav-link"
           href="{{ route('admin.delapankeldata.category', $skpd_category->name) }}">{{ $skpd_category->name }}</a>
       </li>
     @endforeach
     <li class="nav-item"><a class="nav-link" href="{{ route('admin.delapankeldata.index') }}">8 Kel. Data</a></li>
   </ul>
 </li>

 <li
   class="nav-item dropdown {{ request()->is('admin/rpjmd/*') || request()->routeIs('admin.rpjmd.index') ? 'active' : '' }}">
   <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i
       class="fas fa-briefcase"></i><span>RPJMD</span></a>
   <ul class="dropdown-menu">
     @foreach (\App\Models\SkpdCategory::all() as $skpd_category)
       <li class="nav-item"><a class="nav-link"
           href="{{ route('admin.rpjmd.category', $skpd_category->name) }}">{{ $skpd_category->name }}</a>
       </li>
     @endforeach
     <li class="nav-item"><a class="nav-link" href="{{ route('admin.rpjmd.index') }}">RPJMD</a></li>
   </ul>
 </li>

 <li
   class="nav-item {{ request()->is('admin/indikator/*') || request()->routeIs('admin.indikator.index') ? 'active' : '' }}">
   <a class="nav-link" href="{{ route('admin.indikator.index') }}"><i class="fas fa-layer-group"></i>
     <span>Indikator</span></a>
 </li>
 <li class="nav-item {{ request()->is('admin/bps/*') || request()->routeIs('admin.bps.index') ? 'active' : '' }}">
   <a href="{{ route('admin.bps.index') }}" class="nav-link"><i class="fas fa-th-large"></i><span>BPS</span></a>
 </li>
