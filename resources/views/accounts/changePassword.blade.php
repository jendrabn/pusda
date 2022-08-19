@extends('layouts.admin')

@section('title', 'Change Password')

@section('content')
  <div class="card">
    <div class="card-header">
      Change Password
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('updatePassword') }}">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label class="required" for="current_password">Password Sekarang</label>
          <input class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}" type="password"
            name="current_password" id="current_password" value="{{ old('current_password', '') }}">
          @if ($errors->has('current_password'))
            <span class="text-danger">{{ $errors->first('current_password') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>
        <div class="form-group">
          <label class="required" for="password">Password</label>
          <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password"
            id="password" value="{{ old('password', '') }}">
          @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
          <span class="help-block"> </span>
        </div>
        <div class="form-group">
          <label class="required" for="password_confirmation">Konfirmasi Password</label>
          <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" type="password"
            name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation', '') }}">
          @if ($errors->has('password_confirmation'))
            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
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
