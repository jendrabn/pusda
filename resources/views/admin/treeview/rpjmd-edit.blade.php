@extends('admin.treeview.master')

@section('title')
  Edit Menu Tree View RPJMD
@endsection

@section('content')
  <section class="section-header">
    <div class="section-header-back">
      <a href="{{ route('admin.treeview.rpjmd.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Menu Tree View RPJMD</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item"><a href="{{ route('admin.treeview.rpjmd.index') }}">Menu Tree View RPJMD</a>
      </div>
      <div class="breadcrumb-item">Edit</div>
    </div>
  </section>

  <section class="section-body">
    <div class="row">
      <div class="col-12">
        @include('partials.alerts')

        <div class="card">
          <div class="card-header">
            <h4 class="text-uppercase">Edit Data Tree View</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.treeview.rpjmd.update', $tabelRpjmd->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                <div class="col-sm-12 col-md-7">
                  <select name="parent_id" class="form-control select2">
                    @foreach ($categories as $category)
                      @if ($category->id !== $tabelRpjmd->id)
                        <option {{ $tabelRpjmd->parent->id === $category->id ? 'selected' : '' }}
                          value="{{ $category->id }}">
                          {{ $category->menu_name }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Menu <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" name="menu_name" class="form-control" value="{{ $tabelRpjmd->menu_name }}">
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
