<script src="https://cdn.jsdelivr.net/npm/chart.js@3.3.2/dist/chart.min.js"
integrity="sha256-qoN08nWXsFH+S9CtIq99e5yzYHioRHtNB9t2qy1MSmc=" crossorigin="anonymous"></script>
<script>
  function initTreeView(enableClickableLink = false, selector = '#jstree') {
    $(selector).jstree({
      core: {
        themes: {
          responsive: false
        }
      },
      types: {
        default: {
          icon: 'fa fa-folder text-warning'
        },
        file: {
          icon: 'fa fa-file text-warning'
        }
      },
      plugins: ['types']
    });

    if (enableClickableLink) {
      $(selector).on('select_node.jstree', function(e, data) {
        const link = $('#' + data.selected).find('a');
        if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
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
    const modal = $('#modal-edit');
    const {
      uraian,
      satuan,
      uraian_id,
      uraian_parent_id,
      isi,
      ketersedian_data
    } = data;
    modal.find('input[name=uraian]').val(uraian);
    modal.find('input[name=satuan]').val(satuan);
    modal.find('input[name=uraian_id]').val(uraian_id);
    modal.find('input[name=uraian_parent_id]').val(uraian_parent_id);
    if (ketersedian_data) {
      modal.find('select[name=ketersediaan_data]').val(ketersedian_data);
    }
    isi.sort((a, b) => a.tahun - b.tahun);
    isi.forEach((value, index) => modal.find(`input[name=t${++index}]`).val(
      value.isi));
  }

  function handleUpdateSumberData(resourceName) {
    $('select.sumber-data').on('change', function(event) {
      const id = $(this).data('id');
      const form = $('#form-update-sumber-data');
      form.prop('action', `/admin/${resourceName}/sumber_data/${id}`);
      form.find('input[name=sumber_data]').val(event.target.value);
      form.submit();
    });
  }

  function handleShowModalEdit(resourceName) {
    $('#isi-uraian-table').on('click', 'tbody .btn-edit', async function() {
      const id = $(this).data('id');
      await $.ajax({
        url: `/admin/${resourceName}/${id}/edit`,
        type: 'get',
        dataType: 'json',
        success: function(data) {
          console.log(data);
          fillFormEdit(data);
        },
        error: function(error) {
          console.log(error)
        }
      });

      $('#modal-edit').modal('show')
    });
  }

  function handleShowModalGraphic(resourceName) {
    $('#isi-uraian-table').on('click', 'tbody .btn-grafik', async function() {
      const id = $(this).data('id');
      await $.ajax({
        url: `/admin/${resourceName}/${id}/edit`,
        type: 'get',
        dataType: 'json',
        success: function(data) {
          const {
            isi,
            ketersedian_data,
            uraian,
            satuan
          } = data

          const years = data.isi.map(function(v, i) {
            return v.tahun
          }).reverse();
          const isiUraian = data.isi.map(function(v, i) {
            return v.isi;
          }).reverse();

          $('#chart-isi-uraian').remove();
          $('#chart-container').append(
            '<canvas id="chart-isi-uraian" width="100%" height="100%"></canvas>');
          const context = document.getElementById('chart-isi-uraian');
          const chart = new Chart(context, {
            type: 'bar',
            data: {
              labels: years,
              datasets: [{
                label: uraian,
                data: isiUraian,
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                  'rgba(255,99,132,1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true
                  }
                }]
              }
            }
          });
        },
        error: function(error) {
          console.log(error)
        }
      });

      $('#modal-chart').modal('show');
    });
  }

  function handleDeleteFilePendukung(resourceName) {
    $('.btn-delete-file').on('click', function() {
      const id = $(this).data('id');
      const form = $('#form-file-delete');
      form.prop('action', `/admin/${resourceName}/files/${id}`);
      form.submit()
    });
  }

  function handleDeleteIsiUraian(resourceName) {
    $('#isi-uraian-table').on('click', 'tbody .btn-delete', function() {
      const id = $(this).data('id');
      const form = $('#form-delete');
      form.prop('action', `/admin/${resourceName}/${id}`);
      form.submit()
    });
  }

  function initIsiUraianPage(resourceName) {
    $('#isi-uraian-table').DataTable({
      searching: false,
      paging: true,
      ordering: false,
      info: false,
      lengthChange: true,
      aLengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"]
      ],
    });

    $('#chart-download').on('click', function() {
      const canvas = $('#chart-isi-uraian')[0];
      const image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
      const link = document.createElement('a');
      link.download = Date.now() + '.png';
      link.href = image;
      link.click()
    });

    $('#modal-file-upload').on('hidden.bs.modal', function(event) {
      $(this).find('input[name=file_document]').val('');
    });

    $('#modal-edit .modal-footer button[type=submit]').on('click', function() {
      $('#form-edit').submit();
    });

    initTreeView(true);
    handleUpdateSumberData(resourceName);
    handleShowModalEdit(resourceName);
    handleDeleteFilePendukung(resourceName);
    handleDeleteIsiUraian(resourceName);
    handleShowModalGraphic(resourceName);
  }
</script>
