@extends('layouts.admin', ['title' => 'Profil'])

@section('content')
<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Profil</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('update_profile_information') }}" enctype="multipart/form-data">
          @method('PUT') @csrf
          <div class="form-group">
            <label for="role">Role</label>
            <input class="form-control" id="role" type="text" value="{{ $user->role }}" readonly />
          </div>
          <div class="form-group">
            <label for="skpd">SKPD</label>
            <input class="form-control" id="skpd" type="text" value="{{ $user->skpd->nama }}" readonly />
          </div>
          <div class="form-group">
            <label class="required" for="name">Nama Lengkap</label>
            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ $user->name }}" />
            @error('name')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label class="required" for="email">Email</label>
            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ $user->email }}" />
            @error('email')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label class="required" for="username">Username</label>
            <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" type="text" value="{{ $user->username }}" />
            @error('username')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="phone">No. HP/WhatsApp</label>
            <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="tel" value="{{ $user->phone }}" />
            @error('phone')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="address">Alamat</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ $user->address }}</textarea>
            @error('address')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="birth_date">Tanggal Lahir</label>
            <input class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" type="date" value="{{ $user->birth_date }}" />
            @error('birth_date')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="photo">Foto Profil</label>
            <div class="custom-file">
              <input class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo" type="file" accept=".png,.jpg,.jpeg" />
              <label class="custom-file-label" for="photo">Choose file</label>
              @error('photo')
              <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-save"></i> Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Ubah Password</h3>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('update_password') }}">
          @csrf @method('PUT')
          <div class="form-group">
            <label class="required" for="current_password">Password Saat Ini</label>
            <input class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" type="password" />
            @error('current_password')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label class="required" for="password">Password Baru</label>
            <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" />
            @error('password')
            <span class="error invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label class="required" for="password_confirmation">Konfirmasi Password Baru</label>
            <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" />
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">
              <i class="fas fa-save"></i> Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection