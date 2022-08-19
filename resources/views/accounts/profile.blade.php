@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
  <div class="card">
    <div class="card-header">
      Profile
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('updateProfile') }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label class="required" for="name">Name</label>
          <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
            id="name" value="{{ $user->name }}" required>
          @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <label class="required" for="email">Email</label>
          <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email"
            id="email" value="{{ $user->email }}" required>
          @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <label class="required" for="username">Username</label>
          <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" type="text" name="username"
            id="username" value="{{ $user->username }}" required>
          @if ($errors->has('username'))
            <span class="text-danger">{{ $errors->first('username') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password"
            id="password">
          @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <label for="phone">No. HP</label>
          <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="tel" name="phone"
            id="phone" value="{{ $user->phone }}">
          @if ($errors->has('phone'))
            <span class="text-danger">{{ $errors->first('phone') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <label for="address">Alamat</label>
          <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ $user->address }}</textarea>
          @if ($errors->has('address'))
            <span class="text-danger">{{ $errors->first('address') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>

        <div class="form-group">
          <label for="avatar">Avatar</label>
          <input class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}" type="file" name="avatar"
            id="avatar">
          @if ($errors->has('avatar'))
            <span class="text-danger">{{ $errors->first('avatar') }}</span>
          @endif
          <span class="help-block"> </span>
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
