@extends('layouts.admin', ['title' => 'Tambah User'])

@section('content')
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Tambah User
          </h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <a class="btn btn-default" href="{{ route('admin.users.index') }}">
              Back to list
            </a>
          </div>
          <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="form-group">
              <label class="required" for="name">Nama Lengkap</label>
              <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text"
                value="{{ old('name') }}">
              @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="required" for="email">Email</label>
              <input class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                type="email" value="{{ old('email') }}">
              @error('email')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="required" for="username">Username</label>
              <input class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                type="text" value="{{ old('username') }}">
              @error('username')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="required" for="skpd_id">SKPD</label>
              <select class="form-control select2 @error('skpd_id') is-invalid @enderror" id="skpd_id" name="skpd_id">
                <option selected disabled hidden>Pilih SKPD</option>
                @foreach ($skpd as $id => $name)
                  <option value="{{ $id }}" {{ $id == old('skpd_id') ? 'selected' : '' }}>
                    {{ $name }}
                  </option>
                @endforeach
              </select>
              @error('skpd_id')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="required" for="role">Role</label>
              <select class="form-control select2 @error('role') is-invalid @enderror" id="role" name="role">
                <option selected disabled hidden>Pilih Role</option>
                @foreach ($roles as $id => $role)
                  <option value="{{ $id }}" {{ $id == old('role') ? 'selected' : '' }}>
                    {{ $role }}
                  </option>
                @endforeach
              </select>
              @error('role')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label class="required" for="password">Password</label>
              <input class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                type="password">
              @error('password')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label for="phone">No. HP/WhatsApp</label>
              <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                type="tel" value="{{ old('phone') }}">
              @error('phone')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <label for="address">Alamat</label>
              <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address') }}</textarea>
              @error('address')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">
                <i class="fas fa-save"></i> Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
