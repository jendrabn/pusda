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

      $('#dataTable tbody').on('click', '.btn-delete', function() {
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

    })
  </script>
