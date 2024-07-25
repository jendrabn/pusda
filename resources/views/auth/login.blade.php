@extends('layouts.auth', ['title' => 'Log In'])

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>Log In</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
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
                                <span class="fas fa-user"></span>
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
                                <span class="fas fa-lock"></span>
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
                                <input id="remember"
                                       name="remember"
                                       type="checkbox">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary btn-block"
                                    type="submit">Log In</button>
                        </div>
                    </div>
                </form>

                <p class="mt-2 mb-0">
                    <a href="{{ route('auth.forgot-password') }}">Forgot Password?</a>
                </p>
            </div>
        </div>
    </div>
@endsection
