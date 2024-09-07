@extends('layouts.admin', ['title' => 'Profil'])

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Profil</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update_profile') }}"
                          enctype="multipart/form-data"
                          method="POST">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="_id">ID</label>
                            <input class="form-control"
                                   id="_id"
                                   readonly
                                   type="text"
                                   value="{{ $user->id }}" />
                        </div>

                        <div class="form-group">
                            <label for="_role">Role</label>
                            <input class="form-control"
                                   id="_role"
                                   readonly
                                   type="text"
                                   value="{{ $user->role }}" />
                        </div>

                        <div class="form-group">
                            <label for="_skpd">SKPD</label>
                            <input class="form-control"
                                   id="_skpd"
                                   readonly
                                   type="text"
                                   value="{{ $user->skpd?->nama }}" />
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="_name">Nama Lengkap</label>
                            <input class="form-control @error('name') is-invalid @enderror"
                                   id="_name"
                                   name="name"
                                   type="text"
                                   value="{{ $user->name }}" />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="_email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror"
                                   id="_email"
                                   name="email"
                                   type="email"
                                   value="{{ $user->email }}" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="_username">Username</label>
                            <input class="form-control @error('username') is-invalid @enderror"
                                   id="_username"
                                   name="username"
                                   type="text"
                                   value="{{ $user->username }}" />
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="_phone">No. Handphone</label>
                            <input class="form-control @error('phone') is-invalid @enderror"
                                   id="_phone"
                                   name="phone"
                                   type="tel"
                                   value="{{ $user->phone }}" />
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="_address">Alamat</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="_address"
                                      name="address"
                                      rows="2">{{ $user->address }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="_birth_date">Tgl. Lahir</label>
                            <input class="form-control datetimepicker-input date @error('birth_date') is-invalid @enderror"
                                   data-toggle="datetimepicker"
                                   id="_birth_date"
                                   name="birth_date"
                                   placeholder="DD-MM-YYYY"
                                   type="text"
                                   value="{{ $user->birth_date }}" />
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="_avatar">Avatar</label>
                            <div class="custom-file">
                                <input accept=".png,.jpg,.jpeg"
                                       class="form-control-file @error('avatar') is-invalid @enderror"
                                       id="_avatar"
                                       name="avatar"
                                       type="file" />
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button class="btn btn-primary"
                                type="submit">
                            <i class="fa-solid fa-save"></i> Update
                        </button>
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
                    <form action="{{ route('admin.update_password') }}"
                          method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="required"
                                   for="_current_password">Password Aktif</label>
                            <input class="form-control @error('current_password') is-invalid @enderror"
                                   id="_current_password"
                                   name="current_password"
                                   type="password" />
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="_password">Password Baru</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                   id="_password"
                                   name="password"
                                   type="password" />
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="required"
                                   for="_password_confirmation">Konfirmasi Password Baru</label>
                            <input class="form-control"
                                   id="_password_confirmation"
                                   name="password_confirmation"
                                   type="password" />
                        </div>

                        <button class="btn btn-primary"
                                type="submit">
                            <i class="fa-solid fa-save"></i> Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
