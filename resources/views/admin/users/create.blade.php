@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
  <div class="card">
    <div class="card-header text-uppercase">
      Create Users
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="form-group">
          <label class="required" for="name">Name</label>
          <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
            id="name" value="{{ old('name') }}">
          @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required" for="email">Email</label>
          <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
            id="email" value="{{ old('email') }}">
          @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required" for="username">Username</label>
          <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username"
            id="username" value="{{ old('username') }}">
          @if ($errors->has('username'))
            <span class="text-danger">{{ $errors->first('username') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required" for="skpd_id">SKPD</label>
          <select class="form-control select2 {{ $errors->has('skpd_id') ? 'is-invalid' : '' }}" name="skpd_id"
            id="skpd_id" style="width: 100%;">
            <option selected>Please Select</option>
            @foreach ($skpd as $id => $name)
              <option value="{{ $id }}" {{ $id == old('skpd_id') ? 'selected' : '' }}>
                {{ $name }}
              </option>
            @endforeach
          </select>
          @if ($errors->has('skpd_id'))
            <span class="text-danger">{{ $errors->first('skpd_id') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required" for="role">Role</label>
          <select class="form-control select2 {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role"
            id="role" style="width: 100%;">
            <option selected>Please Select</option>
            @foreach ($roles as $id => $role)
              <option value="{{ $id }}" {{ $id == old('role') ? 'selected' : '' }}>
                {{ $role }}
              </option>
            @endforeach
          </select>
          @if ($errors->has('role'))
            <span class="text-danger">{{ $errors->first('role') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label class="required" for="password">Password</label>
          <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password"
            id="password">
          @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label for="phone">No. HP</label>
          <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="tel" name="phone"
            id="phone" value="{{ old('phone') }}">
          @if ($errors->has('phone'))
            <span class="text-danger">{{ $errors->first('phone') }}</span>
          @endif
        </div>

        <div class="form-group">
          <label for="address">Alamat</label>
          <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address') }}</textarea>
          @if ($errors->has('address'))
            <span class="text-danger">{{ $errors->first('address') }}</span>
          @endif
        </div>

        <div class="form-group">
          <button class="btn btn-danger" type="submit">
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection
