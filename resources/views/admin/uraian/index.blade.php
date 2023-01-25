@extends('layouts.admin')

@section('content')
  <div class="row">
    <div class="col-lg-6">
      @if ($tabel)
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              Tambah {{ $tabel->nama_menu }}
            </h3>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.uraian.' . $crudRoutePart . '.store', $tabel->id) }}" method="POST">
              @csrf
              <div class="form-group">
                <label class="required" for="parent_id">Kategori</label>
                <select class="form-control select2 @error('parent_id') is-invalid @enderror" id="parent_id"
                  name="parent_id" style="width: 100%">
                  <option value="">Parent</option>
                  @foreach ($uraian as $item)
                    <option value="{{ $item->id }}">{{ $item->uraian }}</option>
                  @endforeach
                </select>
                @error('parent_id')
                  <span class="error invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label class="required" for="uraian">Uraian</label>
                <input class="form-control @error('uraian') is-invalid @enderror" name="uraian" type="text"
                  value="{{ old('uraian') }}">
                @error('uraian')
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
      @endif
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Pilih Menu Treeview {{ $title }}
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
                                      <li @if (isset($tabel) && $tabel->id === $child->id) data-jstree='{ "selected" : true }' @endif>
                                        <a
                                          href="{{ route('admin.uraian.' . $crudRoutePart . '.index', $child->id) }}">{{ $child->nama_menu }}</a>
                                      </li>
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

  @if ($tabel)
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          Daftar Uraian Form {{ $tabel->nama_menu }}
        </h3>
      </div>
      <div class="card-body">
        <table class="table-bordered table-striped table-hover ajaxTable datatable datatable-uraian table">
          <thead>
            <tr>
              <th width="10"></th>
              <th>ID</th>
              <th>Uraian</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($uraian as $item)
              <tr>
                <td></td>
                <td>{{ $item->id }}</td>
                <td>{{ $item->uraian }}</td>
                <td>
                  <a class="btn btn-xs btn-info"
                    href="{{ route('admin.uraian.' . $crudRoutePart . '.edit', [$tabel->id, $item->id]) }}">
                    Edit
                  </a>
                  <form style="display: inline-block;"
                    action="{{ route('admin.uraian.' . $crudRoutePart . '.destroy', $item->id) }}" method="POST"
                    onsubmit="return confirm('Are You Sure?');">
                    @method('DELETE')
                    @csrf
                    <input class="btn btn-xs btn-danger" type="submit" value="Delete">
                  </form>
                </td>
              </tr>
              @foreach ($item->childs as $item)
                <tr>
                  <td></td>
                  <td>{{ $item->id }}</td>
                  <td style="text-indent: 2rem;">{{ $item->uraian }}</td>
                  <td>
                    <a class="btn btn-xs btn-info"
                      href="{{ route('admin.uraian.' . $crudRoutePart . '.edit', [$tabel->id, $item->id]) }}">
                      Edit
                    </a>
                    <form style="display: inline-block;"
                      action="{{ route('admin.uraian.' . $crudRoutePart . '.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Are You Sure?');">
                      @method('DELETE')
                      @csrf
                      <input class="btn btn-xs btn-danger" type="submit" value="Delete">
                    </form>
                  </td>
                </tr>
              @endforeach
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endif
@endsection

@section('scripts')
  <script>
    $(function() {
      let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

      let deleteButton = {
        text: 'Delete selected',
        url: "{{ route('admin.uraian.' . $crudRoutePart . '.massDestroy') }}",
        className: 'btn-danger',
        action: function(e, dt, node, config) {
          var ids = $.map(dt.rows({
            selected: true
          }).data(), function(entry) {
            return entry[1]
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
        buttons: dtButtons
      };

      let table = $('.datatable-uraian').DataTable(dtOverrideGlobals);
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
      });

    });
  </script>
@endsection
