@extends('layouts.admin')

@section('title', 'Create SKPD')

@section('content')
  <div class="card">
    <div class="card-header">
      Create SKPD
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('admin.skpd.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label class="required" for="skpd_category_id">Kategori</label>
          <select class="form-control select2 {{ $errors->has('skpd_category_id') ? 'is-invalid' : '' }}"
            name="skpd_category_id" id="skpd_category_id" required>
            <option value="" selected>Please select</option>
            @foreach ($categories as $id => $name)
              <option value="{{ $id }}" {{ $id == old('skpd_category_id') ? 'selected' : '' }}>
                {{ $name }}
              </option>
            @endforeach
          </select>
          @if ($errors->has('skpd_category_id'))
            <span class="text-danger">{{ $errors->first('skpd_category_id') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <label class="required" for="nama">Nama</label>
          <input class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" type="text" name="nama"
            id="nama" value="{{ old('nama', '') }}" required>
          @if ($errors->has('nama'))
            <span class="text-danger">{{ $errors->first('nama') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <label class="required" for="singkatan">singkatan</label>
          <input class="form-control {{ $errors->has('singkatan') ? 'is-invalid' : '' }}" type="text" name="singkatan"
            id="singkatan" value="{{ old('singkatan', '') }}" required>
          @if ($errors->has('singkatan'))
            <span class="text-danger">{{ $errors->first('singkatan') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <button class="btn btn-danger" type="submit">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
