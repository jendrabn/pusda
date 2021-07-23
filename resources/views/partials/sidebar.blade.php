  @php
    $home = '/';
    if (Auth::user()->level === 1) {
        $home = route('admin.dashboard');
    } elseif (Auth::user()->level === 1) {
        $home = route('skpd.dashboard');
    }
  @endphp

  <div class="sidebar-brand">
    <a href="{{ $home }}">Pusda</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="{{ $home }}">Pd</a>
  </div>
  <ul class="sidebar-menu">
    @if (Auth::user()->level === 1)
      @include('partials.side-menu-admin')
    @elseif (Auth::user()->level === 2)
      @include('partials.side-menu-skpd')
    @endif

  </ul>

  <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="{{ route('home') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
      <i class="fas fa-rocket"></i> Home Page
    </a>
  </div>
