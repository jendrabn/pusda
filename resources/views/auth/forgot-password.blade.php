@extends('layouts.auth', ['title' => 'Lupa Password'])

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Forgot Password</p>
            <form action="{{ route('auth.forgot-password.post') }}"
                  method="post">
                @csrf
                <div class="input-group has-validation mb-3">
                    <input autofocus
                           class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                           name="username"
                           placeholder="Email / Username"
                           type="text">
                    <div class="input-group-text"> <span class="bi bi-person"></span> </div>
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="d-grid mb-3">
                    <button class="btn btn-primary"
                            type="submit">Request new password
                    </button>
                </div>
            </form>
            <p class="mb-0"> <a href="{{ route('auth.login') }}">Login</a> </p>
        </div>
    </div>
@endsection
