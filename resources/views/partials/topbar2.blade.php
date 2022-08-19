  @php
    $home = '/';
    if (Auth::user()->level === 1) {
        $home = route('admin.dashboard');
    } elseif (Auth::user()->level === 2) {
        $home = route('skpd.dashboard');
    }
  @endphp

  <a href="{{ $home }}" class="navbar-brand sidebar-gone-hide">PUSDA</a>
  <div class="navbar-nav">
    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
  </div>
  <div class="nav-collapse">
    <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
      <i class="fas fa-ellipsis-v"></i>
    </a>
    <ul class="navbar-nav">
      <li class="nav-item"><a href="{{ $home }}" class="nav-link">Dashboard</a></li>
      <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Home Page</a></li>
    </ul>
  </div>
  <form class="form-inline ml-auto">
    <ul class="navbar-nav">
      {{--  --}}
    </ul>
    <div class="search-element">
      {{--  --}}
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
