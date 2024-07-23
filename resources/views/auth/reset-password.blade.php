@extends('layouts.auth', ['title' => 'Reset Password'])

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Reset Password</p>
            <form action="{{ route('auth.reset-password.put', $params) }}"
                  method="post">
                @csrf
                @method('PUT')

                <div class="input-group has-validation mb-3">
                    <input autofocus
                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                           name="password"
                           placeholder="Password"
                           type="password">
                    <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="input-group has-validation mb-3">
                    <input class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                           name="password_confirmation"
                           placeholder="Confirm Password"
                           type="password">
                    <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="d-grid mb-3">
                    <button class="btn btn-primary"
                            type="submit">Reset Password
                    </button>
                </div>
            </form>
            <p class="mb-0"> <a href="{{ route('auth.login') }}">Login</a> </p>
        </div>
    </div>
@endsection
