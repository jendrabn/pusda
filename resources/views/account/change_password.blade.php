@extends('layouts.admin-master')

@section('title')
  Ubah Password
@endsection

@section('content')
  <div class="section-header">
    <h1>Ubah Password</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Ubah Password</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        @include('partials.alerts')
        <div class="card card-primary">
          <div class="card-body mt-4">
            <form action="{{ route('update_password') }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Password Sekarang <code>*</code>
                </label>
                <div class="col-sm-12 col-md-7">
                  <input type="password" class="form-control" name="current_password" tabindex="1">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Password <code>*</code>
                </label>
                <div class="col-sm-12 col-md-7">
                  <input type="password" class="form-control" name="password" tabindex="2">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Konfirmasi Password <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="password" class="form-control" name="password_confirmation" tabindex="3">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <div class="d-flex justify-content-between">
                    <span><code>*</code> Wajib diisi</span>
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
