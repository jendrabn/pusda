@extends('layouts.admin', ['title' => 'Edit ' . $title])

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Edit {{ $tabel->nama_menu }}
      </h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <a class="btn btn-default btn-flat"
          href="{{ route('admin.uraian.' . $crudRoutePart . '.index', $tabel->id) }}">
          Back to list
        </a>
      </div>
      <form action="{{ route('admin.uraian.' . $crudRoutePart . '.update', $uraian->id) }}"
        method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
          <div class="form-group col-lg-6">
            <label class="required"
              for="parent_id">Kategori</label>
            <select class="form-control select2 @error('parent_id') is-invalid @enderror"
              id="parent_id"
              name="parent_id">
              <option value="">Parent</option>
              @foreach ($uraians as $item)
                <option value="{{ $item->id }}"
                  {{ $item->id == $uraian->parent_id ? 'selected' : '' }}>
                  {{ $item->uraian }}</option>
              @endforeach
            </select>
            @error('parent_id')
              <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-lg-6">
            <label class="required"
              for="uraian">Uraian</label>
            <input class="form-control @error('uraian') is-invalid @enderror"
              id="uraian"
              name="uraian"
              type="text"
              value="{{ $uraian->uraian }}">
            @error('uraian')
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
