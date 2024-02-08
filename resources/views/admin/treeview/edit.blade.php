@extends('layouts.admin')

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Edit {{ $title }}
      </h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <a class="btn btn-default btn-flat"
          href="{{ route('admin.treeview.' . $crudRoutePart . '.index') }}">
          Back to list
        </a>
      </div>
      <form action="{{ route('admin.treeview.' . $crudRoutePart . '.update', $tabel->id) }}"
        method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
          <div class="form-group col-lg-6">
            <label class="required"
              for="parent_id">Kategori</label>
            <select class="form-control select2 @error('parent_id') is-invalid @enderror"
              name="parent_id">
              <option selected
                disabled
                hidden>Pilih Kategori</option>
              @foreach ($categories as $category)
                @if ($category->id !== $tabel->id)
                  <option value="{{ $category->id }}"
                    {{ $tabel->parent?->id == $category->id ? 'selected' : '' }}>
                    {{ $category->nama_menu }}
                  </option>
                @endif
              @endforeach
            </select>
            @error('parent_id')
              <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-lg-6">
            <label class="required">Nama Menu</label>
            <input class="form-control @error('nama_menu') is-invalid @enderror"
              name="nama_menu"
              type="text"
              value="{{ $tabel->nama_menu }}">
            @error('nama_menu')
              <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <button class="btn btn-primary btn-flat"
            type="submit">
            <i class="fas fa-save mr-1"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
