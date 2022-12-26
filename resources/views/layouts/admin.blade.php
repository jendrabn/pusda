<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible"
        content="ie=edge">
  <meta name="csrf-token"
        content="{{ csrf_token() }}">

  <title>{{ $title }} | {{ config('app.name') }}</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css"
        rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
  <link href="{{ asset('css/adminlte.min.css') }}"
        rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700"
        rel="stylesheet" />
  {{-- <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
        rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"
        rel="stylesheet" />
  <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css"
        rel="stylesheet" />
  <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"
        rel="stylesheet" /> --}}

  <link type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/sl-1.5.0/datatables.min.css"
        rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css"
        rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css"
        rel="stylesheet">
  <link href="{{ asset('css/custom.css') }}"
        rel="stylesheet" />
  @yield('styles')
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-light bg-white">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link"
             data-widget="pushmenu"
             href="#"><i class="fa fa-bars"></i></a>
        </li>
      </ul>

    </nav>

    @include('partials.menu')

    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content"
               style="padding-top: 20px">
        @if (session('message'))
          <div class="row mb-2">
            <div class="col-lg-12">
              <div class="alert alert-success"
                   role="alert">{{ session('message') }}</div>
            </div>
          </div>
        @endif
        @if ($errors->count() > 0)
          <div class="alert alert-danger">
            <ul class="list-unstyled">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        @yield('content')
      </section>
      <!-- /.content -->
    </div>

    <footer class="main-footer">
      <div class="d-none d-sm-block float-right">
        <b>Version</b> 3.0.0-alpha
      </div>
      <strong> &copy;</strong> All Rights Reserved
    </footer>
    <form id="logoutform"
          style="display: none;"
          action="{{ route('logout') }}"
          method="POST">
      {{ csrf_field() }}
    </form>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  {{-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script> --}}

  <script type="text/javascript"
          src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript"
          src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript"
          src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/sl-1.5.0/datatables.min.js">
  </script>
  <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
  <script
          src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/1.1.1/bs-custom-file-input.min.js"
          integrity="sha512-LGq7YhCBCj/oBzHKu2XcPdDdYj6rA0G6KV0tCuCImTOeZOV/2iPOqEe5aSSnwviaxcm750Z8AQcAk9rouKtVSg=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
  @yield('scripts')
</body>

</html>
