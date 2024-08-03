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
