@extends('layouts.admin-master')

@push('styles')
  <style>
    .dataTables_length select {
      min-width: 65px;
    }

  </style>
@endpush

@push('scripts')
  <script>
    $(function() {
      const keyname = window.location.href;
      const data = JSON.parse(localStorage.getItem(keyname));

      if (data && data.category_id) {
        $('#category').val(data.category_id);
        $('#category').trigger('change');
        const option = $('#category').find(`option[value=${data.category_id}]`).attr('selected', 'selected');
        $('#stay-in-category').prop('checked', true);
      }

      $('#category').on('change', function(e) {
        const data = JSON.parse(localStorage.getItem(keyname));
        if (data && data.category_id) {
          localStorage.setItem(keyname, JSON.stringify({
            category_id: e.target.value
          }))
        }
      });

      $('#stay-in-category').on('change', function(e) {
        const element = $(this);
        const categoryId = $('#category').val();
        if (element.is(':checked')) {
          localStorage.setItem(keyname, JSON.stringify({
            category_id: categoryId
          }));
        } else {
          localStorage.setItem(keyname, JSON.stringify({
            category_id: null
          }));
        }
      });



      $('.uraian-datatable').DataTable({
        ordering: false,
        lengthMenu: [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ]
      });

      $('#treeview').jstree({
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

      // handle link clicks in tree nodes(support target="_blank" as well)
      $('#treeview').on('select_node.jstree', function(e, data) {
        var link = $('#' + data.selected).find('a');
        if (link.attr("href") != "#" && link.attr("href") != "javascript:;" && link.attr("href") != "") {
          if (link.attr("target") == "_blank") {
            link.attr("href").target = "_blank";
          }
          document.location.href = link.attr("href");
          return false;
        }
      });

      $('.uraian-datatable').on('click', 'tbody .btn-delete', function() {
        Swal.fire({
          title: 'Hapus Menu ?',
          text: "Data yang dihapus tidak bisa dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
        }).then((result) => {
          if (result.isConfirmed) {
            $('#form-delete').prop('action', $(this).data('url'))
            $('#form-delete').submit()
          }
        })
      })

    });
  </script>
@endpush
