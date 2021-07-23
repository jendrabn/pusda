@extends('admin.uraian.master')

@section('title')
  Edit Uraian Form Menu Indikator
@endsection

@section('content')
  <section class="section-header">
    <div class="section-header-back">
      <a href="{{ route('admin.uraian.indikator.index', [$tabelIndikator->id]) }}" class="btn btn-icon"><i
          class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Uraian Form Menu Indikator</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item active"> <a href="{{ route('admin.uraian.indikator.index') }}">Uraian Form
          Menu Indikator</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
  </section>

  <section class="section-body">

    <div class="row">
      <div class="col-lg-12">
        @include('partials.alerts')
        <div class="card">
          <div class="card-header">
            <h4 class="text-uppercase">Edit Data Uraian Form "{{ $tabelIndikator->menu_name }}"</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.uraian.indikator.update', $uraianIndikator->id) }}" method="POST">
              @csrf
              @method('PUT')

              <input type="hidden" name="tabel_indikator_id" value="{{ $tabelIndikator->id }}">
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <select name="parent_id" id="" class="form-control select2" tabindex="1">
                    <option value="">Parent</option>
                    @foreach ($uraian as $item)
                      <option {{ $item->id === $uraianIndikator->parent_id ? 'selected' : '' }}
                        value="{{ $item->id }}">
                        {{ $item->uraian }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Uraian <code>*</code></label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="uraian" value="{{ $uraianIndikator->uraian }}"
                    tabindex=" 2">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <div class=" d-flex justify-content-between align-items-center">
                    <span><code>*</code> Wajib Diisi</span>
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
