<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link"
               data-widget="pushmenu"
               href="#"
               role="button"><i class="fa-solid fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center"
               data-toggle="dropdown"
               href="#">
                <img alt="User Image"
                     class="img-circle elevation-2 mr-2"
                     data-toggle="dropdown"
                     height="33"
                     src="{{ Auth::user()->avatar_url }}"
                     width="33" />

                <span class="font-weight-bold">{{ Auth::user()->name }}</span>
            </a>

            <div class="dropdown-menu">
                <a class="dropdown-item btn btn-default"
                   href="{{ route('admin.profile') }}">Pengaturan Akun</a>
                <a class="dropdown-item btn btn-default"
                   href="#"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Log out
                    <form action="{{ route('auth.logout') }}"
                          class="d-none"
                          id="logout-form"
                          method="POST">
                        @csrf
                    </form>
                </a>
            </div>
        </li>
    </ul>
</nav>
