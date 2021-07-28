@extends('admin.uraian.master')

@section('title')
  Detail User
@endsection

@section('content')
  <section class="section-header">
    <div class="section-header-back">
      <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail User</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"> <a href="{{ route('admin.users.index') }}">User</a></div>
      <div class="breadcrumb-item">Detail</div>
    </div>
  </section>

  <section class="section-body">
    <h2 class="section-title">Detail User</h2>
    <p class="section-lead">
      Lorem ipsum dolor sit amet consectetur, adipisicing elit. Neque, obcaecati aut sapiente iste deserunt odit.
    </p>

    <div class="row">
      <div class="col-lg-12">
        @include('partials.alerts')
        <div class="card">
          <div class="card-header">
            <h4>Detail User</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3">
                <div class="user-avatar">
                  <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="img-fluid">
                </div>
              </div>
              <div class="col-lg-9">
                <div class="form-group row">
                  <label for="input-name"
                    class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Nama
                    Lengkap</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="input-name" name="name" value="{{ $user->name }}"
                      readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-role"
                    class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Level</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="input-role" name="role" value="{{ $user->role }}"
                      readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-skpd"
                    class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Nama
                    SKPD</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="input-skpd" name="skpd" value="{{ $user->skpd->nama }}"
                      readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-username"
                    class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Username</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="input-username" name="username"
                      value="{{ $user->username }}" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-email"
                    class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Email</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" id="input-email" name="email" value="{{ $user->email }}"
                      readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-no-hp"
                    class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">No.
                    Hp</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="input-no-hp" name="no_hp"
                      value="{{ $user->no_hp ?? '-' }}" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="input-alamat"
                    class="col-sm-3 col-form-label d-flex align-items-center font-weight-bold text-uppercase">Alamat</label>
                  <div class="col-sm-9">
                    <textarea name="alamat" id="input-alamat" class="form-control h-100"
                      readonly>{{ $user->alamat ?? '-' }}</textarea>
                  </div>
                </div>
              </div>
            </div>
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
