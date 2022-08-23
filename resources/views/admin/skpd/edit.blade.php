@extends('layouts.admin')

@section('title', 'Edit SKPD')

@section('content')
  <div class="card">
    <div class="card-header text-uppercase">
      Edit SKPD
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('admin.skpd.update', $skpd->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="required" for="skpd_kategori_id">Kategori</label>
          <select class="form-control select2 {{ $errors->has('skpd_kategori_id') ? 'is-invalid' : '' }}"
            name="skpd_kategori_id" id="skpd_kategori_id" style="width: 100%">
            <option value="" selected>Please select</option>
            @foreach ($categories as $id => $name)
              <option value="{{ $id }}" {{ $id == $skpd->skpd_category_id ? 'selected' : '' }}>
                {{ $name }}
              </option>
            @endforeach
          </select>
          @if ($errors->has('skpd_kategori_id'))
            <span class="text-danger">{{ $errors->first('skpd_kategori_id') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required" for="nama">Nama</label>
          <input class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" type="text" name="nama"
            id="nama" value="{{ $skpd->nama }}" style="width: 100%">
          @if ($errors->has('nama'))
            <span class="text-danger">{{ $errors->first('nama') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required" for="singkatan">Singkatan</label>
          <input class="form-control {{ $errors->has('singkatan') ? 'is-invalid' : '' }}" type="text" name="singkatan"
            id="singkatan" value="{{ $skpd->singkatan }}" style="width: 100%">
          @if ($errors->has('singkatan'))
            <span class="text-danger">{{ $errors->first('singkatan') }}</span>
          @endif
        </div>

        <div class="form-group">
          <button class="btn btn-danger" type="submit">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
