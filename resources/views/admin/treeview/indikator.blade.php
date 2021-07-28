@extends('layouts.admin-master')

@section('title')
  Menu Tree View Indikator
@endsection

@section('content')
  <section class="section-header">
    <h1>Menu Tree View Indikator</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Menu Tree View Indikator</div>
    </div>
  </section>

  <section class="section-body">
    <h2 class="section-title">Menu Tree View Indikator</h2>
    <p class="section-lead">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nobis, odio minima ipsa
      reprehenderit facilis quis.</p>

    @include('partials.alerts')

    <div class="row">
      <div class="col-12 col-md-6 pr-md-2">
        @include('admin.treeview.partials.menu_tree')
      </div>
      <div class="col-12 col-md-6 pl-md-2">
        @include('admin.treeview.partials.form_add_menu', [
        'action' => route('admin.treeview.indikator.store')])
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h4>Data Menu Tree View</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover" id="dataTable">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Nama Menu</th>
                <th>Parent</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $index => $category)
                <tr>
                  <td class="text-center">{{ ++$index }}</td>
                  <td>{{ $category->nama_menu }}</td>
                  <td>{{ $category->parent->nama_menu ?? '' }}</td>
                  <td class="text-center">
                    @if ($category->id > 1)
                      <div class="btn-group btn-group-sm" role="group" aria-label="Aksi">
                        <a href="{{ route('admin.treeview.indikator.edit', [$category->id]) }}"
                          class="btn btn-warning btn-icon"><i class="fas fa-pencil-alt"></i></a>
                        <button data-url="{{ route('admin.treeview.indikator.destroy', $category->id) }}" type="button"
                          class="btn btn-danger btn-icon btn-delete"><i class="fas fa-trash-alt"></i></button>
                      </div>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <form action="" id="form-delete" method="POST" hidden>@csrf @method('DELETE')</form>
@endsection

@push('scripts')
  @include('admin.treeview.partials.scripts')
@endpush
