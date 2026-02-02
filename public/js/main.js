$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr("content");

  moment.updateLocale("en", {
    week: { dow: 1 }, // Monday is the first day of the week
  });

  $(".date").datetimepicker({
    format: "YYYY-MM-DD",
    locale: "en",
    icons: {
      up: "fas fa-chevron-up",
      down: "fas fa-chevron-down",
      previous: "fas fa-chevron-left",
      next: "fas fa-chevron-right",
    },
  });

  $(".datetime").datetimepicker({
    format: "YYYY-MM-DD HH:mm:ss",
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

  bsCustomFileInput.init();

  const $jsTrees = $(".jstree");
  const folderIcon = "fa fa-folder text-warning";
  const folderOpenIcon = "fa fa-folder-open text-warning";

  const syncJsTreeIcons = function (instance) {
    const nodes = instance.get_json("#", { flat: true });

    nodes.forEach(function (node) {
      const hasChildren = Array.isArray(node.children) && node.children.length > 0;
      if (!hasChildren) {
        instance.set_icon(node.id, folderIcon);
        return;
      }

      instance.set_icon(node.id, instance.is_open(node.id) ? folderOpenIcon : folderIcon);
    });
  };

  $jsTrees.jstree({
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
        icon: "fa fa-folder text-warning",
      },
    },
    plugins: ["types"],
  });

  $jsTrees.on("ready.jstree refresh.jstree", function (e, data) {
    syncJsTreeIcons(data.instance);
  });

  $jsTrees.on("open_node.jstree", function (e, data) {
    if (data.node.children.length > 0) {
      data.instance.set_icon(data.node.id, folderOpenIcon);
    }
  });

  $jsTrees.on("close_node.jstree", function (e, data) {
    if (data.node.children.length > 0) {
      data.instance.set_icon(data.node.id, folderIcon);
    }
  });

  $jsTrees.each(function () {
    const instance = $(this).jstree(true);
    if (instance) {
      syncJsTreeIcons(instance);
    }
  });

  $jsTrees.on("select_node.jstree", function (e, data) {
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
