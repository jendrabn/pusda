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

  <title>{{ config('app.name') }}</title>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css"
    rel="stylesheet" />
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
    rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"
    rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700"
    rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
    rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"
    rel="stylesheet" />
  <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css"
    rel="stylesheet" />
  <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css"
    rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css"
    rel="stylesheet" />
  <link href="{{ asset('plugins/jstree/themes/default/style.css') }}"
    rel="stylesheet">
  <link href="{{ asset('css/custom.css') }}"
    rel="stylesheet" />
  @yield('styles')
</head>

<body class="sidebar-mini layout-fixed"
  style="height: auto;">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link"
            data-widget="pushmenu"
            href="#"><i class="fa fa-bars"></i></a>
        </li>
      </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a class="brand-link"
        href="javascript:;">
        <img class="brand-text img-fluid"
          src="{{ asset('img/logo.png') }}"
          alt="Logo" />
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel d-flex mt-3 mb-3 pb-3">
          <div class="image">
            <img class="img-circle elevation-2"
              src="{{ auth()->user()->photo }}"
              alt="User Image" />
          </div>
          <div class="info">
            <a class="d-block"
              href="{{ route('profile') }}">{{ Str::limit(Str::words(auth()->user()->name, 2, ''), 15, '.') }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        @include('partials.menu')
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <div class="content-wrapper"
      style="min-height: 917px;">
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
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.0-alpha
      </div>
      <strong> &copy;</strong> {{ trans('global.allRightsReserved') }}
    </footer>
    <form id="logoutform"
      style="display: none;"
      action="{{ route('logout') }}"
      method="POST">
      {{ csrf_field() }}
    </form>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
  <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
  <script src="	https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
  <script src="{{ asset('plugins/jstree/jstree.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  <script>
    $(function() {
      $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
        className: 'btn'
      })
      $.extend(true, $.fn.dataTable.defaults, {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        columnDefs: [{
          orderable: false,
          className: 'select-checkbox',
          targets: 0
        }, {
          orderable: false,
          searchable: false,
          targets: -1
        }],
        select: {
          style: 'multi+shift',
          selector: 'td:first-child'
        },
        order: [],
        scrollX: true,
        pageLength: 100,
        dom: 'lBfrtip<"actions">',
        buttons: [{
            extend: 'selectAll',
            className: 'btn-primary',
            text: 'Select all',
            exportOptions: {
              columns: ':visible'
            },
            action: function(e, dt) {
              e.preventDefault()
              dt.rows().deselect();
              dt.rows({
                search: 'applied'
              }).select();
            }
          },
          {
            extend: 'selectNone',
            className: 'btn-primary',
            text: 'Deselect all',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'copy',
            className: 'btn-default',
            text: 'Copy',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'csv',
            className: 'btn-default',
            text: 'CSV',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'excel',
            className: 'btn-default',
            text: 'Excel',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdf',
            className: 'btn-default',
            text: 'PDF',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'print',
            className: 'btn-default',
            text: 'Print',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'colvis',
            className: 'btn-default',
            text: 'Columns',
            exportOptions: {
              columns: ':visible'
            }
          }
        ]
      });

      $.fn.dataTable.ext.classes.sPageButton = '';
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  @yield('scripts')
</body>

</html>
