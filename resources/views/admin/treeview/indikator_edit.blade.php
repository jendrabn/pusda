@extends('layouts.admin-master')

@section('title')
  Edit Menu Tree View Indikator
@endsection

@section('content')
  <section class="section-header">
    <div class="section-header-back">
      <a href="{{ route('admin.treeview.indikator.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Menu Tree View Indikator</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('admin.treeview.indikator.index') }}">Tree View Indikator</a>
      </div>
      <div class="breadcrumb-item">Edit</div>
    </div>
  </section>

  <section class="section-body">
    @include('partials.alerts')

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Edit Data Tree View</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.treeview.indikator.update', $tabelIndikator->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                <div class="col-sm-12 col-md-7">
                  <select name="parent_id" class="form-control select2">
                    @foreach ($categories as $category)
                      @if ($category->id !== $tabelIndikator->id)
                        <option {{ $tabelIndikator->parent->id === $category->id ? 'selected' : '' }}
                          value="{{ $category->id }}">
                          {{ $category->nama_menu }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Menu <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="nama_menu" class="form-control" value="{{ $tabelIndikator->nama_menu }}">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <div class="d-flex justify-content-between align-items-center">
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
