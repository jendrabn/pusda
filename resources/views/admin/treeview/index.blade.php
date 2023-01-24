@extends('layouts.admin')

@section('content')
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Tambah {{ $title }}
          </h3>
        </div>
        <div class="card-body">
          <form action="{{ route('admin.treeview.' . $crudRoutePart . '.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label class="required" for="parent_id">Kategori</label>
              <select class="form-control select2 @error('parent_id') is-invalid @enderror" id="category"
                      name="parent_id">
                @foreach ($categories as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_menu }}</option>
                @endforeach
              </select>
              @error('parent_id')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="required" for="nama_menu">Nama Menu</label>
              <input class="form-control @error('nama_menu') is-invalid @enderror" name="nama_menu" type="text"
                     value="{{ old('nama_menu') }}">
              @error('nama_menu')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-save"></i> Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Tampilan {{ $title }}
          </h3>
        </div>
        <div class="card-body jstree overflow-auto">
          <ul>
            <li data-jstree='{"opened":true}'>
              @if ($crudRoutePart === 'delapankeldata')
                8 Kelompok Data
              @elseif ($crudRoutePart === 'rpjmd')
                RPJMD
              @elseif ($crudRoutePart === 'indikator')
                Indikator
              @elseif ($crudRoutePart === 'bps')
                BPS
              @endif

              @foreach ($categories as $category)
                @if ($category->childs->count())
                  <ul>
                    @foreach ($category->childs as $child)
                      <li>
                        {{ $child->nama_menu }}
                        @if ($child->childs->count())
                          <ul>
                            @foreach ($child->childs as $child)
                              <li> {{ $child->nama_menu }}
                                <ul>
                                  @if ($child->childs->count())
                                    @foreach ($child->childs as $child)
                                      <li> {{ $child->nama_menu }}</li>
                                    @endforeach
                                  @endif
                                </ul>
                              </li>
                            @endforeach
                          </ul>
                        @endif
                      </li>
                    @endforeach
                  </ul>
                @endif
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Daftar {{ $title }}
      </h3>
    </div>
    <div class="card-body">
      <table class="table-bordered table-striped table-hover datatable datatable-MenuTreeview table">
        <thead>
          <tr>
            <th width="10"></th>
            <th>&nbsp;</th>
            <th>ID</th>
            <th>Nama Menu</th>
            <th>Parent</th>
          </tr>
          {{-- <tr>
            <td></td>
            <td>&nbsp;</td>
            <td><input class="search" type="text" placeholder="Cari"></td>
            <td><input class="search" type="text" placeholder="Cari"></td>
            <td><input class="search" type="text" placeholder="Cari"></td>
          </tr> --}}
        </thead>
      </table>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(function() {
      let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
      let deleteButton = {
        text: 'Delete selected',
        url: "{{ route('admin.treeview.' . $crudRoutePart . '.massDestroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
          var ids = $.map(dt.rows({
            selected: true
          }).data(), function(entry) {
            return entry.id
          });

          if (ids.length === 0) {
            alert('No rows selected')
            return
          }

          if (confirm('Are You Sure?')) {
            $.ajax({
                headers: {
                  'x-csrf-token': _token
                },
                method: 'POST',
                url: config.url,
                data: {
                  ids: ids,
                  _method: 'DELETE'
                }
              })
              .done(function() {
                location.reload()
              })
          }
        }
      }
      dtButtons.push(deleteButton)

      let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.treeview.' . $crudRoutePart . '.index') }}",
        columns: [{
            data: 'placeholder',
            name: 'placeholder'
          },
          {
            data: 'actions',
            name: 'actions'
          },
          {
            data: 'id',
            name: 'id'
          },
          {
            data: 'nama_menu',
            name: 'nama_menu'
          },
          {
            data: 'parent',
            name: 'parent.nama_menu'
          },
        ],
        orderCellsTop: true,
        order: [
          [1, 'desc']
        ],
        pageLength: 50,
      };
      let table = $('.datatable-MenuTreeview').DataTable(dtOverrideGlobals);
      $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
      });

      let visibleColumnsIndexes = null;

      $('.datatable thead').on('input', '.search', function() {
        let strict = $(this).attr('strict') || false
        let value = strict && this.value ? "^" + this.value + "$" : this.value

        let index = $(this).parent().index()
        if (visibleColumnsIndexes !== null) {
          index = visibleColumnsIndexes[index]
        }

        table
          .column(index)
          .search(value, strict)
          .draw()
      });

      table.on('column-visibility.dt', function(e, settings, column, state) {
        visibleColumnsIndexes = []
        table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
        });
      })
    });
  </script>
@endsection
