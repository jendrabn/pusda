@extends('layouts.auth', ['title' => 'Reset Password'])

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"><b>Reset Password</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <form action="{{ route('auth.reset-password.put', $params) }}"
                      method="post">
                    @csrf
                    @method('PUT')

                    <div class="input-group has-validation mb-3">
                        <input autofocus
                               class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password"
                               placeholder="New Password"
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

                    <div class="input-group has-validation mb-3">
                        <input class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                               name="password_confirmation"
                               placeholder="Confirm New Password"
                               required
                               type="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary btn-block"
                                    type="submit">Reset Password</button>
                        </div>
                    </div>
                </form>
                <p class="mt-2 mb-0"> <a href="{{ route('auth.login') }}">Login</a> </p>
            </div>
        </div>
    </div>
@endsection
