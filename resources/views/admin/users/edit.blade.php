@extends('layouts.admin', ['title' => 'Show User'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                User <span class="font-weight-bold">#{{ $user->id }}</span>
            </h3>
        </div>
        <div class="card-body">
            <div class="form-group">
                <a class="btn btn-secondary"
                   href="{{ route('admin.users.index') }}">
                    Back to list
                </a>
            </div>
            <form action="{{ route('admin.users.update', $user->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>ID</label>
                        <input class="form-control"
                               readonly
                               type="text"
                               value="{{ $user->id }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="required">Nama Lengkap</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                               name="name"
                               type="text"
                               value="{{ $user->name }}">
                        @error('name')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="required">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               type="email"
                               value="{{ $user->email }}">
                        @error('email')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="required">Username</label>
                        <input class="form-control @error('username') is-invalid @enderror"
                               name="username"
                               type="text"
                               value="{{ $user->username }}">
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
                                <option @selected($id == $user->skpd_id)
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
                                <option @selected($name == $user->role)
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
                        <input class="form-control @error('password') is-invalid @enderror"
                               name="password"
                               type="password">
                        @error('password')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="form-group col-md-6">
                        <label>No. Handphone</label>
                        <input class="form-control @error('phone') is-invalid @enderror"
                               name="phone"
                               type="tel"
                               value="{{ $user->phone }}">
                        @error('phone')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group col-md-6">
                        <label>Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  name="address"
                                  rows="1">{{ $user->address }}</textarea>
                        @error('address')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Tgl. Lahir</label>
                        <input class="form-control datetimepicker-input date @error('birth_date') is-invalid @enderror"
                               data-toggle="datetimepicker"
                               name="birth_date"
                               placeholder="DD-MM-YYYY"
                               type="text"
                               value="{{ $user->birth_date }}" />
                        @error('birth_date')
                            <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="form-group col-md-6">
                        <label>Email Verified At</label>
                        <input class="form-control"
                               readonly
                               type="text"
                               value="{{ $user->email_verified_at }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Created At</label>
                        <input class="form-control"
                               readonly
                               type="text"
                               value="{{ $user->created_at }}">
                    </div>
                </div>

                <p class="text-muted">(<code>*</code>) wajib diisi</p>

                <div class="form-group mb-0 text-right">
                    <button class="btn btn-primary"
                            type="submit">
                        <i class="fas fa-save mr-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
