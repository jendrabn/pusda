@extends('layouts.admin', ['title' => 'Create User'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Create User
            </h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <a class="btn btn-secondary"
                   href="{{ route('admin.users.index') }}">
                    Back to list
                </a>
            </div>
            <form action="{{ route('admin.users.store') }}"
                  method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="required">Nama Lengkap</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                               name="name"
                               type="text"
                               value="{{ old('name') }}">
                        @error('name')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="required">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               type="email"
                               value="{{ old('email') }}">
                        @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="required">Username</label>
                        <input class="form-control @error('username') is-invalid @enderror"
                               name="username"
                               type="text"
                               value="{{ old('username') }}">
                        @error('username')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="required">SKPD</label>
                        <select class="form-control select2 @error('skpd_id') is-invalid @enderror"
                                name="skpd_id"
                                style="width: 100%">
                            <option selected>---</option>
                            @foreach ($skpds as $id => $name)
                                <option @selected($id == old('skpd_id'))
                                        value="{{ $id }}">
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('skpd_id')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="required">Role</label>
                        <select class="form-control select2 @error('role') is-invalid @enderror"
                                name="role"
                                style="width: 100%">
                            <option selected>---</option>
                            @foreach ($roles as $id => $name)
                                <option @selected($name == old('role'))
                                        value="{{ $name }}">
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Password</label>
                        <input class="form-control required @error('password') is-invalid @enderror"
                               name="password"
                               type="password"
                               value="{{ old('password') }}">
                        @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>No. Handphone</label>
                        <input class="form-control @error('phone') is-invalid @enderror"
                               name="phone"
                               type="tel"
                               value="{{ old('phone') }}">
                        @error('phone')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  name="address"
                                  rows="1">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Tgl. Lahir</label>
                        <div class="input-group">
                            <input class="form-control date @error('birth_date') is-invalid @enderror"
                                   name="birth_date"
                                   placeholder="yyyy-mm-dd"
                                   type="text"
                                   value="{{ old('birth_date') }}" />
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
                </div>

                <p class="text-muted">(<code>*</code>) wajib diisi</p>

                <div class="form-group mb-0 text-right">
                    <button class="btn btn-primary"
                            type="submit">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
