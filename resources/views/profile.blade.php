@extends('layouts.admin', ['title' => 'Profil'])

@section('content')
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Informasi Profil
          </h3>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('update_profile_information') }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group text-center">
              <img class="img-circle elevation-2 w-25" src="{{ $user->photo_url }}" alt="User Avatar">
            </div>

            <div class="form-group">
              <label class="required" for="name">Nama</label>
              <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text"
                     value="{{ $user->name }}" required>
              @error('name')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label class="required" for="email">Email</label>
              <input class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                     type="email" value="{{ $user->email }}" required>
              @error('email')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label class="required" for="username">Username</label>
              <input class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                     type="text" value="{{ $user->username }}" required>
              @error('username')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label for="phone">No. HP</label>
              <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                     type="tel" value="{{ $user->phone }}">
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
              <label for="_photo">Foto Profil</label>
              <div class="custom-file">
                <input class="custom-file-input" id="_avatar" name="_photo" type="file" accept=".png,.jpg,.jpeg">
                <label class="custom-file-label" for="_photo">Choose file</label>
              </div>
              @error('_photo')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
              <span class="help-block">Format: JPG, JPEG atau PNG (Maks. 1 MB)</span>
            </div>

            <div class="form-group">
              <button class="btn btn-primary" type="submit">
                Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            Ubah Password
          </h3>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('update_password') }}">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label class="required" for="current_password">Password saat ini</label>
              <input class="form-control @error('current_password') is-invalid @enderror" id="current_password"
                     name="current_password" type="password" value="{{ old('current_password', '') }}">
              @error('current_password')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label class="required" for="password">Password</label>
              <input class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                     type="password" value="{{ old('password', '') }}">
              @error('password')
                <span class="error invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label class="required" for="password_confirmation">Konfirmasi password</label>
              <input class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                     name="password_confirmation" type="password" value="{{ old('password_confirmation', '') }}">

              @error('password_confirmation')
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
    </div>
  </div>
@endsection
