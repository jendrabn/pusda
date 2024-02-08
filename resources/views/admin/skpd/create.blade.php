@extends('layouts.admin', ['title' => 'Tambah SKPD'])

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Tambah SKPD
      </h3>
    </div>
    <div class="card-body">
      <div class="form-group">
        <a class="btn btn-default btn-flat"
          href="{{ route('admin.skpd.index') }}">
          Back to list
        </a>
      </div>
      <form method="POST"
        action="{{ route('admin.skpd.store') }}">
        @csrf

        <div class="form-row">
          <div class="form-group col-lg-6">
            <label class="required"
              for="kategori_skpd_id">Kategori</label>
            <select class="form-control select2 @error('kategori_skpd_id') is-invalid @enderror"
              id="kategori_skpd_id"
              name="kategori_skpd_id"
              required
              autofocus>
              <option selected
                disabled
                hidden>Pilih Kategori</option>
              @foreach ($categories as $id => $nama)
                <option value="{{ $id }}"
                  {{ $id === intval(old('kategori_skpd_id')) ? 'selected' : '' }}>
                  {{ $nama }}
                </option>
              @endforeach
            </select>
            @error('kategori_skpd_id')
              <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-lg-6">
            <label class="required"
              for="nama">Nama</label>
            <input class="form-control @error('nama') is-invalid @enderror"
              id="nama"
              name="nama"
              type="text"
              value="{{ old('nama') }}"
              required>
            @error('nama')
              <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group col-lg-6">
            <label class="required"
              for="singkatan">Singkatan</label>
            <input class="form-control @error('singkatan') is-invalid @enderror"
              id="singkatan"
              name="singkatan"
              type="text"
              value="{{ old('singkatan') }}"
              required>
            @error('singkatan')
              <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <button class="btn btn-primary btn-flat"
            type="submit">
            <i class="fas fa-save mr-1"></i> Simpan
          </button>
        </div>

      </form>
    </div>
  </div>
@endsection
