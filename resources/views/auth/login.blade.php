@extends('layouts.auth-master')
@section('title', 'Login')

@section('content')
  @include('partials.alerts')

  <div class="card">
    <div class="card-header">
      <h4 class="text-uppercase">Login</h4>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
          <label for="username">Username atau Email</label>
          <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
        </div>

        <div class="form-group">
          <div class="d-block">
            <label for="password" class="control-label">Password</label>
            <div class="float-right">
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-small">
                  Lupa Password?
                </a>
              @endif
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" tabindex="2" required>
              <div class="input-group-append">
                <div class="input-group-text" id="password-visible"><i class="fas fa-eye"></i></div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me"
              {{ old('remember') ? 'checked' : '' }}>
            <label class="custom-control-label" for="remember-me">Ingat Saya</label>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Login
          </button>
        </div>
      </form>
    </div>
  </div>
  @if (Route::has('register'))
    <div class="mt-5 text-muted text-center">
      Bulum punya akun? <a href="{{ route('register') }}">Buat Akun</a>
    </div>
  @endif
@endsection


@push('scripts')
  <script>
    $(function() {
      $('#password-visible').on('click', function(event) {
        const input = $('#password');
        const icon = $(this).find('i');
        if (input.attr('type') === 'password') {
          input.attr('type', 'text');
          icon.addClass('fa-eye-slash');
          icon.removeClass('fa-eye');
        } else {
          input.attr('type', 'password');
          icon.removeClass('fa-eye-slash');
          icon.addClass('fa-eye');
        }
      });
    });
  </script>
@endpush
