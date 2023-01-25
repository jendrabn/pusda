@extends('layouts.auth', ['title' => 'Log In'])

@section('content')
  <form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="input-group mb-3">
      <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" required
        autocomplete="username" autofocus name="username" placeholder="Username / Email" value="{{ old('username') }}">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-user"></span>
        </div>
      </div>
      @if ($errors->has('username'))
        <div class="invalid-feedback">
          {{ $errors->first('username') }}
        </div>
      @endif
    </div>
    <div class="input-group mb-3">
      <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
        required placeholder="Password">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock"></span>
        </div>
      </div>
      @if ($errors->has('password'))
        <div class="invalid-feedback">
          {{ $errors->first('password') }}
        </div>
      @endif
    </div>
    <div class="row">
      <div class="col-8">
        <div class="icheck-primary">
          <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
          <label for="remember">
            Remember Me
          </label>
        </div>
      </div>
      <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
      </div>
    </div>
  </form>

  @if (Route::has('password.request'))
    <p class="mb-1">
      <a href="{{ route('password.request') }}">
        Forgot Password?
      </a>
    </p>
  @endif
  @if (Route::has('register'))
    <p class="mb-0">
      <a href="{{ route('register') }}">
        Create New Account
      </a>
    </p>
  @endif
@endsection
