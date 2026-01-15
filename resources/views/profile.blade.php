@extends('layouts.admin', ['title' => 'Profil'])

@section('styles')
    <style>
        .profile-photo-wrapper {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 3px solid #dee2e6;
            overflow: hidden;
            background-color: #f8f9fa;
        }

        .profile-photo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-photo-button {
            position: absolute;
            bottom: 2px;
            right: 2px;
            transform: none;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            background: #ffffff;
            color: #495057;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .profile-photo-button:hover {
            color: #212529;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profil</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_profile') }}"
                          enctype="multipart/form-data"
                          method="POST">
                        @method('PUT') @csrf
                        <div class="form-group text-center">
                            <div class="d-inline-block position-relative">
                                <div class="profile-photo-wrapper">
                                    <img alt="Foto Profil"
                                         id="photo-preview"
                                         src="{{ $user->photo ? $user->photo : asset('img/default-avatar.jpg') }}">
                                </div>
                                <label class="profile-photo-button mb-0"
                                       for="photo">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input accept=".png,.jpg,.jpeg"
                                       class="d-none @error('photo') is-invalid @enderror"
                                       id="photo"
                                       name="photo"
                                       type="file" />
                            </div>
                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input class="form-control"
                                   id="role"
                                   readonly
                                   type="text"
                                   value="{{ $user->role }}" />
                        </div>
                        <div class="form-group">
                            <label for="skpd">SKPD</label>
                            <input class="form-control"
                                   id="skpd"
                                   readonly
                                   type="text"
                                   value="{{ $user->skpd->nama }}" />
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="name">Nama</label>
                            <input class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   type="text"
                                   value="{{ $user->name }}" />
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   type="email"
                                   value="{{ $user->email }}" />
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="username">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror"
                                   id="username"
                                   name="username"
                                   type="text"
                                   value="{{ $user->username }}" />
                            @error('username')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">No. Handphone</label>
                            <input class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   type="tel"
                                   value="{{ $user->phone }}" />
                            @error('phone')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      name="address">{{ $user->address }}</textarea>
                            @error('address')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="birth_date">Tanggal Lahir</label>
                            <input class="form-control @error('birth_date') is-invalid @enderror"
                                   id="birth_date"
                                   name="birth_date"
                                   type="date"
                                   value="{{ $user->birth_date }}" />
                            @error('birth_date')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary"
                                    type="submit">
                                Simpan Perubahan
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
                    <form action="{{ route('update_password') }}"
                          method="POST">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label class="required"
                                   for="current_password">Password Saat Ini</label>
                            <input class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password"
                                   name="current_password"
                                   type="password" />
                            @error('current_password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="password">Password Baru</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   type="password" />
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="password_confirmation">Konfirmasi Password Baru</label>
                            <input class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   type="password" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary"
                                    type="submit">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#photo').on('change', function(event) {
            const file = event.target.files[0];
            if (!file) {
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#photo-preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });
    </script>
@endsection
