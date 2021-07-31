@extends('layouts.admin-master')

@section('title')
  Edit Uraian Form Menu RPJMD
@endsection

@section('content')
  <section class="section-header">
    <div class="section-header-back">
      <a href="{{ route('admin.uraian.rpjmd.index', $tabelRpjmd->id) }}" class="btn btn-icon"><i
          class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Uraian Form Menu RPJMD</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"> <a href="{{ route('admin.uraian.rpjmd.index') }}">Uraian Form
          Menu RPJMD</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
  </section>

  <section class="section-body">
    @include('partials.alerts')

    <div class="card">
      <div class="card-header">
        <h4>Edit Data Uraian Form "{{ $tabelRpjmd->nama_menu }}"</h4>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.uraian.rpjmd.update', $uraianRpjmd->id) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="skpd_id" value="{{ $skpd->id }}">
          <input type="hidden" name="tabel_Rpjmd_id" value="{{ $tabelRpjmd->id }}">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori <code>*</code></label>
            <div class="col-sm-12 col-md-7">
              <select name="parent_id" id="" class="form-control select2" tabindex="1">
                <option value="">Parent</option>
                @foreach ($uraian as $item)
                  <option {{ $item->id === $uraianRpjmd->parent_id ? 'selected' : '' }} value="{{ $item->id }}">
                    {{ $item->uraian }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Uraian <code>*</code></label>
            <div class="col-sm-12 col-md-7">
              <input type="text" class="form-control" name="uraian" value="{{ $uraianRpjmd->uraian }}" tabindex=" 2">
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
  </section>
@endsection
