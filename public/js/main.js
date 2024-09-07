$(document).ready(function () {
	window._token = $('meta[name="csrf-token"]').attr("content");

	moment.updateLocale("id", {
		week: { dow: 1 }, // Monday is the first day of the week
	});

	$(".date").datetimepicker({
		format: "DD-MM-YYYY",
		viewMode: "years",
	});

	$(".datetime").datetimepicker({
		format: "DD-MM-YYYY HH:mm:ss",
		sideBySide: true,
	});

	$(".timepicker").datetimepicker({
		format: "HH:mm:ss",
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

	$(".jstree").jstree({
		core: {
			themes: {
				responsive: false,
			},
		},
		types: {
			default: {
				icon: "fa-solid fa-folder text-warning",
			},
			file: {
				icon: "fa-solid fa-file text-warning",
			},
		},
		plugins: ["types"],
	});

	$(".jstree").on("select_node.jstree", function (e, data) {
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
