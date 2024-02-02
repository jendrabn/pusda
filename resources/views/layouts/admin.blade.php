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
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
    rel="stylesheet" />
  <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"
    rel="stylesheet">
  <link type="text/css"
    href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/sl-1.5.0/datatables.min.css"
    rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
    rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.css"
    rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css"
    rel="stylesheet">
  <link href="{{ asset('plugins/jstree/themes/default/style.css') }}"
    rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"
    rel="stylesheet">

  <link href="{{ asset('css/custom.css') }}"
    rel="stylesheet">
  @yield('styles')
  @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link"
            data-widget="pushmenu"
            href="#"
            role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
      </ul>
    </nav>
    <!-- /.navbar -->

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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper"
      style="min-height:  917px">

      <!-- Main content -->
      <div class="content"
        style="padding-top: 20px">

        @if (session('success-message'))
          <div class="alert alert-success">
            <h5><i class="icon fas fa-check"></i> Success</h5>
            {{ session('success-message') }}
          </div>
        @endif

        @if (session('error-message'))
          <div class="alert alert-danger">
            <h5><i class="icon fas fa-ban"></i> Error!</h5>
            {{ session('error-message') }}
          </div>
        @endif

        {{-- @if ($errors->any())
        <div class="alert alert-danger">
          <h5><i class="icon fas fa-ban"></i> Error!</h5>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif --}}

        @yield('content')
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="d-none d-sm-inline float-right">Version 2</div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2017-{{ date('Y') }}
        <a href="#">Pusat Data Kab. Situbondo</a>. </strong>
      All rights reserved.
    </footer>

  </div>
  <!-- ./wrapper -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.min.js"></script>
  <script src="	https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

  <!-- Datatable -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script
    src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/sl-1.5.0/datatables.min.js">
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="{{ asset('plugins/jstree/jstree.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

  <script>
    $(function() {
      bsCustomFileInput.init();

      window._token = $('meta[name="csrf-token"]').attr("content");

      $.ajaxSetup({
        headers: {
          'x-csrf-token': _token
        }
      });

      $(".jstree").jstree({
        core: {
          themes: {
            responsive: false,
          },
        },
        types: {
          default: {
            icon: "fa fa-folder text-warning",
          },
          file: {
            icon: "fa fa-file text-warning",
          },
        },
        plugins: ["types"],
      });

      $(".jstree").on("select_node.jstree", function(e, data) {
        var link = $("#" + data.selected).find("a");
        if (
          link.attr("href") != "#" &&
          link.attr("href") != "javascript:;" &&
          link.attr("href") != ""
        ) {
          if (link.attr("target") == "_blank") {
            link.attr("href").target = "_blank";
          }
          document.location.href = link.attr("href");
          return false;
        }
      });

      moment.updateLocale("en", {
        week: {
          dow: 1
        }, // Monday is the first day of the week
      });

      $(".date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        icons: {
          up: "fas fa-chevron-up",
          down: "fas fa-chevron-down",
          previous: "fas fa-chevron-left",
          next: "fas fa-chevron-right",
        },
      });

      $(".datetime").datetimepicker({
        format: "DD-MM-YYYY HH:mm:ss",
        locale: "en",
        sideBySide: true,
        icons: {
          up: "fas fa-chevron-up",
          down: "fas fa-chevron-down",
          previous: "fas fa-chevron-left",
          next: "fas fa-chevron-right",
        },
      });

      $(".timepicker").datetimepicker({
        format: "HH:mm:ss",
        icons: {
          up: "fas fa-chevron-up",
          down: "fas fa-chevron-down",
          previous: "fas fa-chevron-left",
          next: "fas fa-chevron-right",
        },
      });

      $(".select-all").click(function() {
        let $select2 = $(this).parent().siblings(".select2");
        $select2.find("option").prop("selected", "selected");
        $select2.trigger("change");
      });

      $(".deselect-all").click(function() {
        let $select2 = $(this).parent().siblings(".select2");
        $select2.find("option").prop("selected", "");
        $select2.trigger("change");
      });

      $(".select2").select2();

      $(".treeview").each(function() {
        var shouldExpand = false;
        $(this)
          .find("li")
          .each(function() {
            if ($(this).hasClass("active")) {
              shouldExpand = true;
            }
          });
        if (shouldExpand) {
          $(this).addClass("active");
        }
      });

      $('a[data-widget^="pushmenu"]').click(function() {
        setTimeout(function() {
          $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        }, 300);
      });

      $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
        className: 'btn'
      })

      $.extend(true, $.fn.dataTable.defaults, {
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.13.1/i18n/id.json'
        },
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
          },
          {
            orderable: false,
            searchable: false,
            targets: 1
          }
        ],
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
  @stack('scripts')
</body>

</html>
