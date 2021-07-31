@extends('layouts.admin-master')

@section('title')
  Profil
@endsection

@section('content')
  <section class="section-header">
    <h1>Profil</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Profil</div>
    </div>
  </section>

  <section class="section-body">
    <div class="row">
      <div class="col-lg-12">
        @include('partials.alerts')
        <div class="card card-primary">
          <div class="card-body mt-4">
            <form action="{{ route('update_profile', $user->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-lg-3">
                  <div class="user-avatar">
                    <button class="change-avatar btn btn-dark" role="button" aria-label="change-avatar"
                      id="btn-change-avatar">
                      <i class="fas fa-camera"></i>
                    </button>
                    <input type="file" hidden id="input-avatar" name="avatar">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="img-fluid" tabindex="1">
                  </div>
                </div>
                <div class="col-lg-9">
                  <div class="form-group row">
                    <label for="input-name"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Nama
                      Lengkap <code>*</code>
                    </label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="input-name" name="name" value="{{ $user->name }}"
                        tabindex="2">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-role"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Level
                      <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="input-role" value="{{ $user->role }}" tabindex="3"
                        readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-skpd"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Nama
                      SKPD <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="input-skpd" value="{{ $user->skpd->nama }}" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-username"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Username
                      <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="input-username" name="username"
                        value="{{ $user->username }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-email"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Email
                      <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="input-email" name="email" value="{{ $user->email }}"
                        tabindex="4">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-no-hp"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">No.
                      Hp</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="input-no-hp" name="no_hp" value="{{ $user->no_hp }}"
                        tabindex="5">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-alamat"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Alamat</label>
                    <div class="col-sm-9">
                      <textarea name="alamat" id="input-alamat" class="form-control h-100"
                        tabindex="6">{{ $user->alamat }}</textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-alamat" class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                      <div class="d-flex justify-content-between">
                        <span><code>*</code> Wajib diisi</span>
                        <button type="submit" class="btn btn-primary" tabindex="7">Simpan Perubahan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('styles')
  <style>
    .user-avatar {
      width: 100%;
      padding: 0.25rem;
      background-color: #F9F9F9;
      border: 1px solid #dee2e6;
      border-radius: 0.25rem;
      height: auto;
      display: block;
      position: relative;
    }

    .user-avatar .change-avatar {
      position: absolute;
      top: 0.25rem;
      right: 0.25rem;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0.5rem;
    }

    .user-avatar .change-avatar i {
      font-size: 1rem;
    }

  </style>
@endpush



@push('scripts')
  <script>
    $(function() {
      $('#btn-change-avatar').on('click', function(e) {
        e.preventDefault();
        $('#input-avatar').click();
      });

      $('#input-avatar').on('change', function() {
        if (($(this)[0].files) && ($(this)[0].files[0])) {
          const reader = new FileReader();
          reader.onload = function(e) {
            $('.user-avatar img').attr('src', e.target.result)
          }
          reader.readAsDataURL((($(this))[0]).files[0]);
        }
      });
    });
  </script>
@endpush
