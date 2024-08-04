<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1"
          name="viewport" />
    <meta content="{{ csrf_token() }}"
          name="csrf-token" />

    <title>
        {{ isset($title) ? $title : 'Home' }} | {{ config('app.name') }}
    </title>

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
          rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
          rel="stylesheet" />

    <link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.2/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/r-3.0.2/sl-2.0.3/datatables.min.css"
          rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
          rel="stylesheet" />

    <link href="https://preview.keenthemes.com/html/keen/docs/assets/plugins/custom/jstree/jstree.bundle.css"
          rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css"
          rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
          rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css"
          rel="stylesheet">
    @vite('resources/scss/adminlte/adminlte.scss')

    @yield('styles')
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"
                       data-widget="pushmenu"
                       href="#"
                       role="button"><i class="fas fa-bars"></i></a>
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
                        <a class="dropdown-item"
                           href="{{ route('profile') }}">Pengaturan Akun</a>
                        <a class="dropdown-item"
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

        @include('partials.sidebar')

        <div class="content-wrapper">
            <div class="content"
                 style="padding-top: 20px">
                @yield('content')
            </div>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Versi 2.0
            </div>
            <strong>Copyright &copy; 2017-{{ date('Y') }}
                <a href="https://satudata.situbondokab.go.id">Pusat Data Situbondo</a>.</strong>
            All rights reserved.
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
            src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.2/b-3.1.0/b-colvis-3.1.0/b-html5-3.1.0/b-print-3.1.0/r-3.0.2/sl-2.0.3/datatables.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.16/jstree.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/id.min.js"></script>
    <script
            src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script>
        $(function() {
            window._token = $('meta[name="csrf-token"]').attr("content");

            // Toastr
            toastr.options = {
                closeButton: false,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: "toast-top-right",
                preventDuplicates: false,
                onclick: null,
                showDuration: 300,
                hideDuration: 1000,
                timeOut: 5000,
                extendedTimeOut: 1000,
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            };

            $.ajaxSetup({
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error(jqXHR.responseJSON.message || errorThrown, "Error");
                },
            });

            // DataTable
            $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
                className: "btn",
            });

            $.extend(true, $.fn.dataTable.defaults, {
                language: {
                    url: "https://cdn.datatables.net/plug-ins/2.1.3/i18n/en-GB.json",
                },
                order: [
                    [1, "desc"]
                ],
                scrollX: true,
                pageLength: 10,
                dom: 'lBfrtip<"actions">',
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"],
                ],
            });

            $.fn.dataTable.ext.classes.sPageButton = "";

            $('a[data-widget^="pushmenu"]').click(function() {
                setTimeout(function() {
                    $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                }, 350);
            });

            // Moment
            moment.updateLocale("id", {
                week: {
                    dow: 1
                },
            });

            // Datetimepicker
            $(".date").datetimepicker({
                format: "DD-MM-YYYY",
                viewMode: "years",
            });


            $(".datetime").datetimepicker({
                format: "DD-MM-YYYY HH:mm:ss",
                locale: "id",
                sideBySide: true,
            });

            $(".timepicker").datetimepicker({
                format: "HH:mm:ss",
            });

            // Select2
            $(".select2").select2();

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

            // Treeview
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

            // Jstree
            $(".jstree").jstree({
                core: {
                    themes: {
                        responsive: false
                    }
                },
                types: {
                    default: {
                        icon: "fas fa-folder text-warning"
                    },
                    file: {
                        icon: "fas fa-file text-warning"
                    },
                },
                plugins: ["types"]
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
        });
    </script>
    @yield('scripts')
    @stack('scripts')
</body>

</html>
