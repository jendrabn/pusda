@extends('layouts.admin', ['title' => 'Edit User'])

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Edit User
            </h3>
        </div>
        <div class="card-body">
            <a class="btn btn-default mb-3"
               href="{{ route('admin.users.index') }}">
                Back to list
            </a>

            <form action="{{ route('admin.users.update', $user->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="required"
                           for="_name">Nama Lengkap</label>
                    <input autofocus
                           class="form-control @error('name') is-invalid @enderror"
                           id="_name"
                           name="name"
                           type="text"
                           value="{{ $user->name }}">
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
                           value="{{ $user->email }}">
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
                           value="{{ $user->username }}">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required"
                           for="_skpd_id">SKPD</label>
                    <select class="form-control select2 @error('skpd_id') is-invalid @enderror"
                            id="_skpd_id"
                            name="skpd_id"
                            style="width: 100%">
                        <option selected
                                value="">---</option>
                        @foreach ($skpds as $id => $name)
                            <option @selected($id == $user->skpd_id)
                                    value="{{ $id }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('skpd_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="required"
                           for="_role">Role</label>
                    <select class="form-control select2 @error('role') is-invalid @enderror"
                            id="_role"
                            name="role"
                            style="width: 100%">
                        <option selected
                                value="">---</option>
                        @foreach ($roles as $id => $name)
                            <option @selected($name == $user->role)
                                    value="{{ $name }}">
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="_password">Password</label>
                    <input class="form-control @error('password') is-invalid @enderror"
                           id="_password"
                           name="password"
                           type="password" />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                </div>

                <div class="form-group">
                    <label for="_phone">No. Handphone</label>
                    <input class="form-control @error('phone') is-invalid @enderror"
                           id="_phone"
                           name="phone"
                           type="tel"
                           value="{{ $user->phone }}">
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
                    <input autocomplete="off"
                           class="form-control datetimepicker-input date @error('birth_date') is-invalid @enderror"
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

                <button class="btn btn-primary"
                        type="submit">
                    <i class="fa-solid fa-save"></i> Update
                </button>
            </form>
        </div>
    </div>
@endsection
