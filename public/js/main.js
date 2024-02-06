$(function () {
  window._token = $('meta[name="csrf-token"]').attr("content");

  bsCustomFileInput.init();

  $(".menu__treeview").jstree({
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

  $(".menu__treeview").on("select_node.jstree", function (e, data) {
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
    week: { dow: 1 }, // Monday is the first day of the week
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

  $(".select-all").click(function () {
    let $select2 = $(this).parent().siblings(".select2");
    $select2.find("option").prop("selected", "selected");
    $select2.trigger("change");
  });
  $(".deselect-all").click(function () {
    let $select2 = $(this).parent().siblings(".select2");
    $select2.find("option").prop("selected", "");
    $select2.trigger("change");
  });

  $(".select2").select2();

  $(".treeview").each(function () {
    var shouldExpand = false;
    $(this)
      .find("li")
      .each(function () {
        if ($(this).hasClass("active")) {
          shouldExpand = true;
        }
      });
    if (shouldExpand) {
      $(this).addClass("active");
    }
  });

  $('a[data-widget^="pushmenu"]').click(function () {
    setTimeout(function () {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    }, 350);
  });

  let copyButton = "Copy";
  let csvButton = "CSV";
  let excelButton = "Excel";
  let pdfButton = "PDF";
  let printButton = "Print";
  let colvisButton = "Columns";
  let selectAllButton = "Select all";
  let selectNoneButton = "Deselect all";

  let languages = {
    en: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json",
  };

  $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
    className: "btn",
  });
  $.extend(true, $.fn.dataTable.defaults, {
    language: {
      url: languages["en"],
    },
    columnDefs: [
      {
        orderable: false,
        className: "select-checkbox",
        targets: 0,
      },
      {
        orderable: false,
        searchable: false,
        targets: -1,
      },
    ],
    select: {
      style: "multi+shift",
      selector: "td:first-child",
    },
    order: [],
    scrollX: true,
    pageLength: 50,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    dom: 'lBfrtip<"actions">',
    buttons: [
      {
        extend: "selectAll",
        className: "btn-primary",
        text: selectAllButton,
        exportOptions: {
          columns: ":visible",
        },
        action: function (e, dt) {
          e.preventDefault();
          dt.rows().deselect();
          dt.rows({
            search: "applied",
          }).select();
        },
      },
      {
        extend: "selectNone",
        className: "btn-primary",
        text: selectNoneButton,
        exportOptions: {
          columns: ":visible",
        },
      },
      {
        extend: "copy",
        className: "btn-default",
        text: copyButton,
        exportOptions: {
          columns: ":visible",
        },
      },
      {
        extend: "csv",
        className: "btn-default",
        text: csvButton,
        exportOptions: {
          columns: ":visible",
        },
      },
      {
        extend: "excel",
        className: "btn-default",
        text: excelButton,
        exportOptions: {
          columns: ":visible",
        },
      },
      {
        extend: "pdf",
        className: "btn-default",
        text: pdfButton,
        exportOptions: {
          columns: ":visible",
        },
      },
      {
        extend: "print",
        className: "btn-default",
        text: printButton,
        exportOptions: {
          columns: ":visible",
        },
      },
      {
        extend: "colvis",
        className: "btn-default",
        text: colvisButton,
        exportOptions: {
          columns: ":visible",
        },
      },
    ],
  });

  $.fn.dataTable.ext.classes.sPageButton = "";
});
