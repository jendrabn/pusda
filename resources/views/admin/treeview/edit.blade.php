@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-header ">
      Edit {{ $title }}
    </div>
    <div class="card-body">
      <form action="{{ route('admin.treeview.' . $crudRoutePart . '.update', $table->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="required" for="parent_id">Kategori</label>
          <select name="parent_id" class="form-control select2" style="width: 100%">
            @foreach ($categories as $category)
              @if ($category->id !== $table->id)
                <option {{ $table->parent->id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">
                  {{ $category->nama_menu }}</option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="required">Nama Menu</label>
          <input type="text" name="nama_menu" class="form-control" value="{{ $table->nama_menu }}">
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-danger">Update</button>
        </div>

      </form>
    </div>
  </div>
@endsection
