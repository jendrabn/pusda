@extends('layouts.admin', ['title' => 'Edit ' . $title])

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Edit {{ $table->nama_menu }}
      </h3>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.uraian.' . $crudRoutePart . '.update', $uraian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="required" for="parent_id">Kategori</label>
          <select class="form-control select2" id="parent_id" name="parent_id" style="width: 100%">
            <option value="">Parent</option>
            @foreach ($uraians as $item)
              <option value="{{ $item->id }}" {{ $item->id == $uraian->parent_id ? 'selected' : '' }}>
                {{ $item->uraian }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="required" for="uraian">Uraian</label>
          <input class="form-control" id="uraian" name="uraian" type="text" value="{{ $uraian->uraian }}">
        </div>

        <div class="form-group">
          <button class="btn btn-danger" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
@endsection
