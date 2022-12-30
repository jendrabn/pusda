@extends('layouts.admin', ['title' => 'Edit SKPD'])

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Edit SKPD
      </h3>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('admin.skpd.update', $skpd->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="required" for="kategori_skpd_id">Kategori</label>
          <select class="form-control @error('kategori_skpd_id') is-invalid @enderror" id="kategori_skpd_id"
                  name="kategori_skpd_id">
            <option selected disabled hidden>Pilih Kategori</option>
            @foreach ($categories as $id => $nama)
              <option value="{{ $id }}" {{ $id == $skpd->kategori_skpd_id ? 'selected' : '' }}>
                {{ $nama }}
              </option>
            @endforeach
          </select>
          @error('kategori_skpd_id')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="required" for="nama">Nama</label>
          <input class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" type="text"
                 value="{{ $skpd->nama }}">
          @error('nama')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="required" for="singkatan">Singkatan</label>
          <input class="form-control @error('singkatan') is-invalid @enderror" id="singkatan" name="singkatan"
                 type="text" value="{{ $skpd->singkatan }}">
          @error('singkatan')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <button class="btn btn-primary" type="submit">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
