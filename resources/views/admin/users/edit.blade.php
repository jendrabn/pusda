@extends('layouts.admin', ['title' => 'Edit User'])

@section('content')
  <div class="card">
    <div class="card-header">
      Edit User
    </div>
    <div class="card-body">
      <form method="POST"
            action="{{ route('admin.users.update', [$user->id]) }}"
            enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label class="required"
                 for="name">Name</label>
          <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                 id="name"
                 name="name"
                 type="text"
                 value="{{ $user->name }}">
          @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required"
                 for="email">Email</label>
          <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                 id="email"
                 name="email"
                 type="email"
                 value="{{ $user->email }}">
          @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required"
                 for="username">Username</label>
          <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}"
                 id="username"
                 name="username"
                 type="text"
                 value="{{ $user->username }}"
                 required>
          @if ($errors->has('username'))
            <span class="text-danger">{{ $errors->first('username') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required"
                 for="skpd_id">SKPD</label>
          <select class="form-control select2 {{ $errors->has('skpd_id') ? 'is-invalid' : '' }}"
                  id="skpd_id"
                  name="skpd_id"
                  style="width: 100%">
            <option selected>Please Select</option>
            @foreach ($skpd as $id => $name)
              <option value="{{ $id }}"
                      {{ $id == $user->skpd_id ? 'selected' : '' }}>
                {{ $name }}
              </option>
            @endforeach
          </select>
          @if ($errors->has('skpd_id'))
            <span class="text-danger">{{ $errors->first('skpd_id') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required"
                 for="role">Role</label>
          <select class="form-control select2 {{ $errors->has('role') ? 'is-invalid' : '' }}"
                  id="role"
                  name="role"
                  style="width: 100%">
            <option selected>Please Select</option>
            @foreach ($roles as $id => $role)
              <option value="{{ $id }}"
                      {{ $id == $user->role ? 'selected' : '' }}>
                {{ $role }}
              </option>
            @endforeach
          </select>
          @if ($errors->has('role'))
            <span class="text-danger">{{ $errors->first('role') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                 id="password"
                 name="password"
                 type="password">
          @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label for="phone">No. HP</label>
          <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                 id="phone"
                 name="phone"
                 type="tel"
                 value="{{ old('phone') }}">
          @if ($errors->has('phone'))
            <span class="text-danger">{{ $errors->first('phone') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label for="address">Alamat</label>
          <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                    id="address"
                    name="address">{{ $user->address }}</textarea>
          @if ($errors->has('address'))
            <span class="text-danger">{{ $errors->first('address') }}</span>
          @endif
        </div>

        <div class="form-group">
          <button class="btn btn-danger"
                  type="submit">
            Update
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
