@extends('layouts.auth', ['title' => 'Log In'])

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Log In</p>
            <form action="{{ route('auth.login.post') }}"
                  method="post">
                @csrf
                <div class="input-group has-validation mb-3">
                    <input autofocus
                           class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                           name="username"
                           placeholder="Email / Username"
                           type="text"
                           value="{{ env('DEMO_MODE') ? env('DEMO_MODE_USERNAME') : '' }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-user"></i>
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
                           type="password"
                           value="{{ env('DEMO_MODE') ? env('DEMO_MODE_PASSWORD') : '' }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
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
                        <div class="icheck-primary">
                            <input {{ old('remember') ? 'checked' : '' }}
                                   id="remember"
                                   name="remember"
                                   type="checkbox">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-primary btn-block"
                                type="submit">Log In
                        </button>
                    </div>
                </div>
            </form>

            <p class="mb-0 mt-3"> <a href="{{ route('auth.forgot-password') }}">Lupa Password?</a> </p>
        </div>
    </div>
@endsection
