@extends('layouts.auth', ['title' => 'Forgot Password'])

@section('content')
    <p class="login-box-msg">Forgot Password</p>

    <form action="{{ route('auth.forgot-password.post') }}"
          method="post">
        @csrf

        <div class="input-group has-validation mb-3">
            <input autofocus
                   class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                   name="username"
                   placeholder="Email / Username"
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

        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-block"
                        type="submit">Request new password</button>
            </div>
        </div>
    </form>

    <p class="mt-3 mb-0"> <a href="{{ route('auth.login') }}">Login</a> </p>
@endsection
