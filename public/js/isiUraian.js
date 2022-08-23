const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

function initIsiUraianPage(resourceName, role) {
    initTreeView(true);
    handleUpdateSumberData(resourceName, role);
    handleShowModalEdit(resourceName, role);
    handleDeleteFilePendukung(resourceName, role);
    handleDeleteIsiUraian(resourceName, role);
    handleShowModalGraphic(resourceName, role);
    handleDeleteYear();

    $("#isi-uraian-table").DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json",
        },
        searching: false,
        paging: true,
        ordering: false,
        info: false,
        lengthChange: true,
    });

    $("select#tahun").select2();

    $("#modal-add-year").on("hidden.bs.modal", function (e) {
        $("select#tahun").val(null).trigger("change");
    });

    $("#chart-download").on("click", function () {
        const canvas = $("#chart-isi-uraian")[0];
        const image = canvas
            .toDataURL("image/png")
            .replace("image/png", "image/octet-stream");
        const link = document.createElement("a");
        link.download = Date.now() + ".png";
        link.href = image;
        link.click();
    });

    $("#modal-file-upload").on("hidden.bs.modal", function () {
        $(this).find("input[name=file_document]").val("");
    });

    $("#modal-edit .modal-footer button[type=submit]").on("click", function () {
        $(this).addClass("btn-progress");
        $("#form-edit").submit();
    });
}

function initTreeView(enableClickableLink = false, selector = "#jstree") {
    $(selector).jstree({
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

    if (enableClickableLink) {
        $(selector).on("select_node.jstree", function (e, data) {
            const link = $("#" + data.selected).find("a");
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
    }
}

function fillFormEdit(data) {
    const modal = $("#modal-edit");
    const {
        uraian,
        satuan,
        uraian_id,
        uraian_parent_id,
        isi,
        ketersediaan_data,
    } = data;

    modal.find("input[name=uraian]").val(uraian);
    modal.find("input[name=satuan]").val(satuan);
    modal.find("input[name=uraian_id]").val(uraian_id);
    modal.find("input[name=uraian_parent_id]").val(uraian_parent_id);

    if (ketersediaan_data && ketersediaan_data != undefined) {
        modal
            .find("select[name=ketersediaan_data]")
            .val(ketersediaan_data ? 1 : 0);
    }

    isi.sort(function (a, b) {
        return a.tahun - b.tahun;
    });

    isi.forEach(function (value) {
        modal.find(`input[name=tahun_${value.tahun}]`).val(value.isi);
    });
}

function handleUpdateSumberData(resourceName, role) {
    $("#isi-uraian-table").on("change", "select.sumber-data", function (event) {
        const id = $(this).data("id");
        const form = $("#form-update-sumber-data");
        form.prop("action", `/${role}/${resourceName}/sumber_data/${id}`);
        form.find("input[name=sumber_data]").val(event.target.value);
        form.submit();
    });
}

function handleShowModalEdit(resourceName, role) {
    $("#isi-uraian-table").on("click", "tbody .btn-edit", function () {
        const btn = $(this);
        const id = $(this).data("id");
        $.ajax({
            url: `/${role}/${resourceName}/${id}/edit`,
            type: "get",
            dataType: "json",
            beforeSend: function () {
                btn.addClass("btn-progress");
            },
            success: function (data) {
                fillFormEdit(data);
                $("#modal-edit").modal("show");
                btn.removeClass("btn-progress");
            },
            error: function (error) {
                const errorMessage = error.status + ": " + error.statusText;
                Toast.fire({
                    icon: "error",
                    title: errorMessage,
                });
                btn.removeClass("btn-progress");
            },
        });
    });
}

function handleShowModalGraphic(resourceName, role) {
    $("#isi-uraian-table").on("click", "tbody .btn-grafik", function () {
        const btn = $(this);
        const id = $(this).data("id");
        $.ajax({
            url: `/${role}/${resourceName}/${id}/edit`,
            type: "get",
            dataType: "json",
            beforeSend: function () {
                btn.addClass("btn-progress");
            },
            success: function (data) {
                const { isi, uraian } = data;

                const years = isi
                    .map(function (value) {
                        return value.tahun;
                    })
                    .reverse();

                const isiUraian = isi
                    .map(function (value) {
                        return value.isi;
                    })
                    .reverse();

                $("#chart-isi-uraian").remove();
                $("#chart-container").append(
                    '<canvas id="chart-isi-uraian" width="100%" height="100%"></canvas>'
                );

                const context = document.getElementById("chart-isi-uraian");
                const chart = new Chart(context, {
                    type: "bar",
                    data: {
                        labels: years,
                        datasets: [
                            {
                                label: uraian,
                                data: isiUraian,
                                backgroundColor: [
                                    "rgba(255, 99, 132, 0.2)",
                                    "rgba(54, 162, 235, 0.2)",
                                    "rgba(255, 206, 86, 0.2)",
                                    "rgba(75, 192, 192, 0.2)",
                                    "rgba(153, 102, 255, 0.2)",
                                    "rgba(255, 159, 64, 0.2)",
                                ],
                                borderColor: [
                                    "rgba(255,99,132,1)",
                                    "rgba(54, 162, 235, 1)",
                                    "rgba(255, 206, 86, 1)",
                                    "rgba(75, 192, 192, 1)",
                                    "rgba(153, 102, 255, 1)",
                                    "rgba(255, 159, 64, 1)",
                                ],
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        beginAtZero: true,
                                    },
                                },
                            ],
                        },
                    },
                });
                $("#modal-chart").modal("show");
                btn.removeClass("btn-progress");
            },
            error: function (error) {
                const errorMessage = error.status + ": " + error.statusText;
                Toast.fire({
                    icon: "error",
                    title: errorMessage,
                });
                btn.removeClass("btn-progress");
            },
        });
    });
}

function handleDeleteFilePendukung(resourceName, role) {
    $(".btn-delete-file").on("click", function () {
        const id = $(this).data("id");
        const form = $("#form-file-delete");
        form.prop("action", `/${role}/${resourceName}/files/${id}`);
        form.submit();
    });
}

function handleDeleteIsiUraian(resourceName, role = null) {
    $("#isi-uraian-table").on("click", "tbody .btn-delete", function () {
        const id = $(this).data("id");
        const form = $("#form-delete");
        form.prop("action", `/${role}/${resourceName}/${id}`);
        form.submit();
    });
}

function handleDeleteYear() {
    $("button.hapus-tahun").on("click", function (e) {
        const url = $(this).data("url");
        const form = $("#form-delete-year");
        form.prop("action", url);
        Swal.fire({
            title: "Ingin menghapus tahun ?",
            text: "Semua isi uraian yang terkait dengan tahun tersebut akan dihapus!",
            icon: "warning",
            showCancelButton: true,
            showConfirmButton: true,
            cancelButtonText: "Batal",
            confirmButtonText: "Hapus",
            cancelButtonColor: "#cdd3d8",
            confirmButtonColor: "#6777ef",
            showLoaderOnConfirm: true,
        }).then(function (result) {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
}
