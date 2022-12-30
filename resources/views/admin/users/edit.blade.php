@extends('layouts.admin', ['title' => 'Edit User'])

@section('content')
  <div class="card">
    <div class="card-header">
      Edit User
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label class="required" for="name">Nama</label>
          <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text"
                 value="{{ $user->name }}">
          @error('name')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="required" for="email">Email</label>
          <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email"
                 value="{{ $user->email }}">
          @error('email')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="required" for="username">Username</label>
          <input class="form-control @error('username') is-invalid @enderror" id="username" name="username"
                 type="text" value="{{ $user->username }}">
          @error('username')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="required" for="skpd_id">SKPD</label>
          <select class="form-control select2 @error('skpd_id') is-invalid @enderror" id="skpd_id" name="skpd_id">
            <option selected disabled hidden>Pilih SKPD</option>
            @foreach ($skpd as $id => $name)
              <option value="{{ $id }}" {{ $id == $user->skpd_id ? 'selected' : '' }}>
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
              <option value="{{ $id }}" {{ $id == $user->role ? 'selected' : '' }}>
                {{ $role }}
              </option>
            @endforeach
          </select>
          @error('role')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                 type="password">
          @error('password')
            <span class="error invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="phone">No. HP</label>
          <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="tel"
                 value="{{ $user->phone }}">
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
          <button class="btn btn-primary" type="submit">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
