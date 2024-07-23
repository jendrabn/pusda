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
                           type="text">
                    <div class="input-group-text"> <span class="bi bi-person"></span> </div>
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
                           type="password">
                    <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="form-check">
                            <input class="form-check-input"
                                   id="flexCheckDefault"
                                   name="remember"
                                   type="checkbox"> <label class="form-check-label"
                                   for="flexCheckDefault">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary"
                                    type="submit">Log In
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <p class="mb-0"> <a href="{{ route('auth.forgot-password') }}">Lupa Password?</a> </p>
        </div>
    </div>
@endsection
