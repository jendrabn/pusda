@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-header ">
      Pilih Menu Treeview {{ $title }}
    </div>
    <div class="card-body jstreeMenu overflow-auto">
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
                                  <li @if (isset($table) && $table->id === $child->id) data-jstree='{ "selected" : true }' @endif>
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

  @if ($table)
    <div class="card">
      <div class="card-header ">
        Tambah {{ $table->nama_menu }}
      </div>
      <div class="card-body">
        <form action="{{ route('admin.uraian.' . $crudRoutePart . '.store') }}" method="POST">
          @csrf
          <input type="hidden" name="table_id" value="{{ $table->id }}">

          <div class="form-group">
            <label class="required" for="parent_id">Kategori</label>
            <select name="parent_id" class="form-control select2" id="parent_id" style="width: 100%">
              <option value="">Parent</option>
              @foreach ($uraian as $item)
                <option value="{{ $item->id }}">{{ $item->uraian }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="required" for="uraian">Uraian</label>
            <input type="text" class="form-control" name="uraian" value="{{ old('uraian') }}">
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-danger">Save</button>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header ">
        Uraian Form {{ $table->nama_menu }} List
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Uraian">
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
                    href="{{ route('admin.uraian.' . $crudRoutePart . '.edit', [$table->id, $item->id]) }}">
                    Edit
                  </a>
                  <form action="{{ route('admin.uraian.' . $crudRoutePart . '.destroy', $item->id) }}" method="POST"
                    onsubmit="return confirm('Are You Sure?');" style="display: inline-block;">
                    @method('DELETE')
                    @csrf
                    <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                  </form>
                </td>
              </tr>
              @foreach ($item->childs as $item)
                <tr>
                  <td></td>
                  <td>{{ $item->id }}</td>
                  <td style="text-indent: 1rem;">{{ $item->uraian }}</td>
                  <td>
                    <a class="btn btn-xs btn-info"
                      href="{{ route('admin.uraian.' . $crudRoutePart . '.edit', [$table->id, $item->id]) }}">
                      Edit
                    </a>
                    <form action="{{ route('admin.uraian.' . $crudRoutePart . '.destroy', $item->id) }}" method="POST"
                      onsubmit="return confirm('Are You Sure?');" style="display: inline-block;">
                      @method('DELETE')
                      @csrf
                      <input type="submit" class="btn btn-xs btn-danger" value="Delete">
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
  @parent
  <script>
    $(function() {
      $('.datatable-Uraian').DataTable({
        pageLength: 50,
      });
    });
  </script>
@endsection
