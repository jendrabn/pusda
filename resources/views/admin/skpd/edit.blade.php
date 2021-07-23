@extends('admin.uraian.master')

@section('title')
  Edit SKPD
@endsection

@section('content')
  <section class="section-header">
    <div class="section-header-back">
      <a href="{{ route('admin.skpd.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit SKPD</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"> <a href="{{ route('admin.skpd.index', 1) }}">Data SKPD</a>
      </div>
      <div class="breadcrumb-item">Edit</div>
    </div>
  </section>

  <section class="section-body">
    <div class="row">
      <div class="col-lg-12">
        @include('partials.alerts')
        <div class="card">
          <div class="card-header">
            <h4 class="text-uppercase">Edit SKPD</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.skpd.update', $skpd->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="nama" value="{{ $skpd->nama }}" tabindex=" 2">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Singkatan <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="singkatan" value="{{ $skpd->singkatan }}" tabindex=" 2">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <select name="skpd_category_id" id="" class="form-control" tabindex="1">
                    @foreach ($categories as $category)
                      <option {{ $category->id === $skpd->skpd_category_id ? 'selected' : '' }}
                        value="{{ $category->id }}">
                        {{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <div class=" d-flex justify-content-between align-items-center">
                    <span><code>*</code> Wajib diisi</span>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
