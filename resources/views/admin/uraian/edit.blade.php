@extends('layouts.admin', ['title' => 'Edit ' . $title])

@section('content')
  <div class="card">
    <div class="card-header ">
      Edit {{ $table->nama_menu }}
    </div>
    <div class="card-body">
      <form action="{{ route('admin.uraian.' . $crudRoutePart . '.update', $uraian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="required" for="parent_id">Kategori</label>
          <select name="parent_id" class="form-control select2" id="parent_id" style="width: 100%">
            <option value="">Parent</option>
            @foreach ($uraians as $item)
              <option {{ $item->id == $uraian->parent_id ? 'selected' : '' }} value="{{ $item->id }}">
                {{ $item->uraian }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="required" for="uraian">Uraian</label>
          <input type="text" class="form-control" name="uraian" value="{{ $uraian->uraian }}" id="uraian">
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-danger">Update</button>
        </div>
      </form>
    </div>
  </div>
@endsection
