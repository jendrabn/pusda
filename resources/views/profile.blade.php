@extends('layouts.admin', ['title' => 'Profil'])

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
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label>Role</label>
                            <input class="form-control"
                                   readonly
                                   type="text"
                                   value="{{ $user->role }}" />
                        </div>

                        <div class="form-group">
                            <label>SKPD</label>
                            <input class="form-control"
                                   readonly
                                   type="text"
                                   value="{{ $user->skpd->nama }}" />
                        </div>

                        <div class="form-group">
                            <label class="required">Nama Lengkap</label>
                            <input class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   type="text"
                                   value="{{ $user->name }}" />
                            @error('name')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   type="email"
                                   value="{{ $user->email }}" />
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror"
                                   name="username"
                                   type="text"
                                   value="{{ $user->username }}" />
                            @error('username')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>No. Handphone</label>
                            <input class="form-control @error('phone') is-invalid @enderror"
                                   name="phone"
                                   type="tel"
                                   value="{{ $user->phone }}" />
                            @error('phone')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      name="address"
                                      rows="1">{{ $user->address }}</textarea>
                            @error('address')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Tgl. Lahir</label>
                            <div class="input-group">
                                <input class="form-control date @error('birth_date') is-invalid @enderror"
                                       name="birth_date"
                                       placeholder="yyyy-mm-dd"
                                       type="text"
                                       value="{{ $user->birth_date }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                            @error('birth_date')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Avatar</label>
                            <div class="image mb-3">
                                <img class="img-circle elevation-2"
                                     src="{{ $user->avatar_url }}"
                                     style="width: 50px; height: 50px; object-fit: cover;" />
                            </div>
                            <div class="custom-file">
                                <input accept=".png,.jpg,.jpeg"
                                       class="form-control-file @error('avatar') is-invalid @enderror"
                                       name="avatar"
                                       type="file" />
                                @error('avatar')
                                    <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <p class="text-muted">(<code>*</code>) wajib diisi</p>

                        <div class="form-group text-right mb-0">
                            <button class="btn btn-primary"
                                    type="submit">
                                <i class="fas fa-save mr-1"></i> Update
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
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="required">Password Aktif</label>
                            <input class="form-control @error('current_password') is-invalid @enderror"
                                   name="current_password"
                                   type="password" />
                            @error('current_password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required">Password Baru</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   type="password" />
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required">Konfirmasi Password Baru</label>
                            <input class="form-control"
                                   name="password_confirmation"
                                   type="password" />
                        </div>

                        <p class="text-muted">(<code>*</code>) wajib diisi</p>

                        <div class="form-group text-right mb-0">
                            <button class="btn btn-primary"
                                    type="submit">
                                <i class="fas fa-save mr-1"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
