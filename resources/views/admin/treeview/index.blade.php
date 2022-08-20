@extends('layouts.admin')

@section('title', 'Menu Treeview ' . $title)

@section('content')

  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header text-uppercase">
          Tampilan Menu Treeview "{{ $title }}"
        </div>
        <div class="card-body">
          <div class="jstreeMenu overflow-auto">
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
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header text-uppercase">
          Tambah Data Menu Treeview "{{ $title }}"
        </div>
        <div class="card-body">
          <form action="{{ route('admin.treeview.' . $crudRoutePart . '.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label class="required" for="parent_id">Kategori</label>
              <select name="parent_id" class="form-control select2" id="category">
                <option value="">Parent</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->nama_menu }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label class="required" for="nama_menu">Nama Menu</label>
              <input class="form-control" type="text" name="nama_menu" value="{{ old('nama_menu') }}">
            </div>

            <div class="form-group">
              <button class="btn btn-danger" type="submit">
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header text-uppercase">
      Data Menu Treeview "{{ $title }}"
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped table-hover datatable datatable-MenuTreeview">
        <thead>
          <tr>
            <th width="10">

            </th>
            <th>
              ID
            </th>
            <th>
              Nama Menu
            </th>
            <th>
              Parent
            </th>
            <th>
              &nbsp;
            </th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
@endsection

@section('scripts')
  @parent
  <script>
    $(function() {
      let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
      let deleteButtonTrans = 'Delete selected';
      let deleteButton = {
        text: deleteButtonTrans,
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
          {
            data: 'actions',
            name: 'Actions'
          }
        ],
        orderCellsTop: true,
        order: [
          [1, 'desc']
        ],
        pageLength: 25,
      };
      let table = $('.datatable-MenuTreeview').DataTable(dtOverrideGlobals);
      $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
        $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
      });

      let visibleColumnsIndexes = null;

      table.on('column-visibility.dt', function(e, settings, column, state) {
        visibleColumnsIndexes = []
        table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
        });
      })
    });
  </script>
@endsection
