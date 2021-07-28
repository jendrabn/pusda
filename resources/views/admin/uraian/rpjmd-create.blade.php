@extends('admin.uraian.master')

@section('title')
  Uraian Form Menu RPJMD
@endsection

@section('content')
  <section class="section-header">
    <h1>Uraian Form Menu RPJMD</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Uraian Form Menu RPJMD</div>
    </div>
  </section>

  <section class="section-body">
    @include('partials.alerts')
    {{-- TREEVIEW --}}
    <div class="card">
      <div class="card-header">
        <h4 class="text-uppercase">Pilih Menu Treeview</h4>
        <div class="card-header-action">
          <a data-collapse="#treeview-card-collapse" class="btn btn-icon btn-info" href="#"><i
              class="fas fa-minus"></i></a>
        </div>
      </div>
      <div class="collapse show" id="treeview-card-collapse">
        <div class="card-body overflow-auto">
          <div id="treeview" class="tree-demo">
            @include('admin.uraian.partials.menu-tree')
          </div>
        </div>
      </div>
    </div>
    {{-- TREEVIEW --}}

    {{-- FORM INPUT --}}
    <div class="card">
      <div class="card-header">
        <h4 class="text-uppercase">Tambah Data Uraian Form "{{ $tabelRpjmd->nama_menu }}"</h4>
        <div class="card-header-action">
          <a data-collapse="#uraian-form-card-collapse" class="btn btn-icon btn-info" href="#"><i
              class="fas fa-minus"></i></a>
        </div>
      </div>
      <div class="collapse show" id="uraian-form-card-collapse">
        <div class="card-body">
          <form action="{{ route('admin.uraian.rpjmd.store') }}" method="POST">
            @csrf
            <input type="hidden" name="skpd_id" value="{{ $skpd->id }}">
            <input type="hidden" name="tabel_rpjmd_id" value="{{ $tabelRpjmd->id }}">
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori <code>*</code></label>
              <div class="col-sm-12 col-md-7">
                <select name="parent_id" class="form-control select2" tabindex="1" id="category">
                  <option value="none" selected disabled hidden>--Pilih Kategori--</option>
                  <option value="">Parent</option>
                  @foreach ($uraian as $item)
                    <option value="{{ $item->id }}">{{ $item->uraian }}</option>
                  @endforeach
                </select>
                <div class="custom-control custom-checkbox mt-2">
                  <input name="stay" type="checkbox" class="custom-control-input" id="stay-in-category">
                  <label class="custom-control-label" for="stay-in-category">Tetap di kategori ini</label>
                </div>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Uraian <code>*</code></label>
              <div class="col-sm-12 col-md-7">
                <input type="text" class="form-control" name="uraian" value="{{ request()->old('uraian') }}"
                  tabindex=" 2">
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7 text-right">
                <div class="d-flex justify-content-between align-items-center">
                  <span><code>*</code> Wajib diisi</span>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{-- FORM INPUT --}}

    {{-- URAIAN --}}
    <div class="card">
      <div class="card-header">
        <h4 class="text-uppercase">Data Uraian Form</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover uraian-datatable">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Uraian</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($uraian as $index => $item)
                <tr>
                  <td class="text-center" style="width: 2%">{{ ++$index }}</td>
                  <td>{{ $item->uraian }}</td>
                  <td style="min-width: 65px;">
                    <div class="buttons text-center">
                      <button data-url="{{ route('admin.uraian.rpjmd.destroy', $item->id) }}"
                        class=" btn btn-icon btn-sm btn-danger m-0 btn-delete"><i class="fas fa-trash-alt"></i></button>
                      <a href="{{ route('admin.uraian.rpjmd.edit', [$tabelRpjmd->id, $item->id]) }}"
                        class="btn btn-icon btn-sm btn-warning m-0"><i class="fas fa-pencil-alt"></i></a>
                    </div>
                  </td>
                </tr>
                @foreach ($item->childs as $index => $item)
                  <tr>
                    <td></td>
                    <td>&nbsp;&nbsp;&nbsp;{{ $item->uraian }}</td>
                    <td style="min-width: 65px">
                      <div class="buttons text-center">
                        <button data-url="{{ route('admin.uraian.rpjmd.destroy', $item->id) }}"
                          class=" btn btn-icon btn-sm btn-danger m-0 btn-delete"><i class="fas fa-trash-alt"></i></button>
                        <a href="{{ route('admin.uraian.rpjmd.edit', [$tabelRpjmd->id, $item->id]) }}"
                          class="btn btn-icon btn-sm btn-warning m-0"><i class="fas fa-pencil-alt"></i></a>
                      </div>
                    </td>
                  </tr>
                @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    {{-- URAIAN --}}

    <form id="form-delete" action="" method="POST" hidden>@csrf @method('DELETE')</form>
  </section>
@endsection
