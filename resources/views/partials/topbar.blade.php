<form class="form-inline mr-auto">
  <ul class="navbar-nav mr-3">
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    {{-- <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li> --}}
  </ul>
  <div class="search-element">
    {{-- Search Form --}}
  </div>
</form>
<ul class="navbar-nav navbar-right">

  <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="{{ Auth::user()->avatar_url }}" class="rounded-circle mr-1">
      <div class="d-sm-none d-lg-inline-block">{{ greeting(Auth::user()->name) }}</div>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
      {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}
      <a href="{{ route('profile') }}" class="dropdown-item has-icon">
        <i class="far fa-user"></i> Profil
      </a>
      <a href="{{ route('changePassword') }}" class="dropdown-item has-icon">
        <i class="fas fa-key"></i> Ubah Password
      </a>
      <div class="dropdown-divider"></div>
      <a onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" href="#"
        class="dropdown-item has-icon text-danger">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
      </form>
    </div>
  </li>
</ul>
