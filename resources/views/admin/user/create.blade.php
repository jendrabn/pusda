@extends('layouts.admin-master')

@section('title')
  Tambah User
@endsection

@section('content')
  <section class="section-header">
    <div class="section-header-back">
      <a href="{{ route('admin.users.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Tambah User</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"><a href="{{ route('admin.users.index') }}">User</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
  </section>

  <section class="section-body">
    <h2 class="section-title">Tambah User</h2>
    <p class="section-lead">
      Lorem ipsum dolor sit, amet consectetur adipisicing elit. Reiciendis iusto quam voluptatum. Similique, molestias
      non?
    </p>
    <div class="row">
      <div class="col-lg-12">
        @include('partials.alerts')
        <div class="card">
          <div class="card-header">
            <h4>Tambah User</h4>
            <div class="card-header-action">
              <a class="btn btn-icon icon-left btn-primary" href="{{ route('admin.users.index') }}"><i
                  class="fas fa-search-plus"></i> Data User</a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="post">
              @csrf
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3">Nama Skpd
                  <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control select2" name="skpd_id" autofocus tabindex="1">
                    <option value="none" disabled selected hidden>-- Pilih SKPD--</option>
                    @foreach ($skpd as $id => $nama)
                      <option {{ request()->old('skpd_id') == $id ? 'selected' : '' }} value="{{ $id }}">
                        {{ $nama }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3">Level
                  <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="level" id="level1" checked value="1">
                    <label class="form-check-label" for="level1">
                      Administrator
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="level" id="level2" value="2">
                    <label class="form-check-label" for="level2">
                      SKPD
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3">Nama User
                  <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="name" value="{{ request()->old('name') }}" tabindex="2">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3">Username
                  <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="username" value="{{ request()->old('username') }}"
                    tabindex="3">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3">Email
                  <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="email" class="form-control" name="email" value="{{ request()->old('email') }}"
                    tabindex="4">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3">No. Hp</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="no_hp" value="{{ request()->old('no_hp') }}"
                    tabindex="5">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3">Password
                  <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="password" value="{{ request()->old('password') }}"
                    tabindex="6">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3">Alamat</label>
                <div class="col-sm-12 col-md-7">
                  <textarea name="alamat" class="form-control h-100" rows="3"
                    tabindex="7">{{ request()->old('alamat') }}</textarea>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-uppercase text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <div class="d-flex justify-content-between">
                    <span><code>*</code> Wajib diisi</span>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
