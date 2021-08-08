@extends('layouts.admin-master')

@section('title')
  Edit User
@endsection

@section('content')
  <section class="section-header">
    <div class="section-header-back">
      <a href="{{ route('admin.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit User</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}">User</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
  </section>

  <section class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Edit User</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-lg-3">
                  <div class="user-avatar">
                    <button class="change-avatar btn btn-dark" role="button" aria-label="change-avatar"
                      id="btn-change-avatar">
                      <i class="fas fa-camera"></i>
                    </button>
                    <input type="file" hidden id="input-avatar" name="avatar" accept="image/*" tabindex="-1">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="img-fluid">
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
                        tabindex="1">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-role"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Level
                      <code>*</code></label>
                    <div class="col-sm-9">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="level" id="level-1" tabindex="2"
                          {{ $user->level == 1 ? 'checked' : '' }} value="1">
                        <label class="form-check-label" for="level-1">
                          Administrator
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="level" id="level-2" value="2" tabindex="3"
                          {{ $user->level == 2 ? 'checked' : '' }}>
                        <label class="form-check-label" for="level-2">
                          SKPD
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-skpd"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Nama
                      SKPD <code>*</code></label>
                    <div class="col-sm-9">
                      <select class="form-control select2" name="skpd_id" tabindex="4">
                        <option value="none" disabled selected hidden>-- Pilih SKPD--</option>
                        @foreach ($skpd as $id => $nama)
                          <option {{ $user->skpd->id == $id ? 'selected' : '' }} value="{{ $id }}">
                            {{ $nama }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-username"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Username
                      <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="input-username" name="username"
                        value="{{ $user->username }}" tabindex="5">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-email"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Email
                      <code>*</code></label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="input-email" name="email" value="{{ $user->email }}"
                        tabindex="6">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-no-hp"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">No.
                      Hp</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="input-no-hp" name="no_hp" value="{{ $user->no_hp }}"
                        tabindex="7">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-password"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Password</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="input-password" name="password" tabindex="8">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-alamat"
                      class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Alamat</label>
                    <div class="col-sm-9">
                      <textarea name="alamat" id="input-alamat" class="form-control h-100"
                        tabindex="9">{{ $user->alamat }}</textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="input-alamat" class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                      <div class="d-flex justify-content-between">
                        <span><code>*</code> Wajib diisi</span>
                        <button type="submit" class="btn btn-primary" tabindex="10">Simpan Perubahan</button>
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
