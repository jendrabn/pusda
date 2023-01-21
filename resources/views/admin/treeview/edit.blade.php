@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Edit {{ $title }}
      </h3>
    </div>
    <div class="card-body">
      <form action="{{ route('admin.treeview.' . $crudRoutePart . '.update', $table->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="required" for="parent_id">Kategori</label>
          <select class="form-control select2" name="parent_id">
            @foreach ($categories as $category)
              @if ($category->id !== $table->id)
                <option value="{{ $category->id }}" {{ $table->parent?->id == $category->id ? 'selected' : '' }}>
                  {{ $category->nama_menu }}</option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label class="required">Nama Menu</label>
          <input class="form-control" name="nama_menu" type="text" value="{{ $table->nama_menu }}">
        </div>
        <div class="form-group">
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
@endsection
