@extends('layouts.app')
@section('content')
  <div class="login-box">
    <div class="login-logo">
      <div class="login-logo">
        <a href="">
          {{ config('app.name') }}
        </a>
      </div>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">
          Login
        </p>

        @if (session()->has('message'))
          <p class="alert alert-info">
            {{ session()->get('message') }}
          </p>
        @endif

        <form action="{{ route('login') }}" method="POST">
          @csrf

          <div class="form-group">
            <input id="username" type="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}"
              required autocomplete="username" autofocus placeholder="Username/Email" name="username"
              value="{{ old('username', null) }}">

            @if ($errors->has('username'))
              <div class="invalid-feedback">
                {{ $errors->first('username') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
              name="password" required placeholder="Password">

            @if ($errors->has('password'))
              <div class="invalid-feedback">
                {{ $errors->first('password') }}
              </div>
            @endif
          </div>


          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">
                Login
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        @if (Route::has('password.request'))
          <p class="mb-1">
            <a href="{{ route('password.request') }}">
              Forgot Password?
            </a>
          </p>
        @endif
        <p class="mb-1">

        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
@endsection
