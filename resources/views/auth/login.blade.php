@extends('layouts.auth', ['title' => 'Log In'])

@section('content')
    <p class="login-box-msg">Log In</p>

    <form action="{{ route('auth.login.post') }}"
          method="POST">
        @csrf
        <div class="input-group has-validation mb-3">
            <input autofocus
                   class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                   name="username"
                   placeholder="Username / Email"
                   required
                   type="text">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa-solid fa-user"></span>
                </div>
            </div>
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="input-group has-validation mb-3">
            <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                   name="password"
                   placeholder="Password"
                   required
                   type="password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fa-solid fa-lock"></span>
                </div>
            </div>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="row">
            <div class="col-8">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input"
                           id="remember"
                           name="remember"
                           type="checkbox">
                    <label class="custom-control-label"
                           for="remember">Remember Me</label>
                </div>
            </div>
            <div class="col-4">
                <button class="btn btn-primary btn-block"
                        type="submit">Log In</button>
            </div>
        </div>
    </form>

    <p class="mt-3 mb-0">
        <a href="{{ route('auth.forgot-password') }}">Forgot Password?</a>
    </p>
@endsection
