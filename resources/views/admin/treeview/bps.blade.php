@extends('admin.treeview.master')

@section('title')
  Menu Tree View BPS
@endsection

@section('content')
  <section class="section-header">
    <h1>Menu Tree View BPS</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Menu Tree View BPS</div>
    </div>
  </section>

  <section class="section-body">
    @include('partials.alerts')
    <div class="row">
      <div class="col-12 col-md-6 pr-md-2">
        @include('admin.treeview.partials.menu-tree')
      </div>
      <div class="col-12 col-md-6 pl-md-2">
        @include('admin.treeview.partials.add-treeview-menu', [
        'action' => route('admin.treeview.bps.store')])
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h4 class="text-uppercase">Data Menu Tree View</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover" id="dataTable">
            <thead>
              <tr>
                <th class="text-center" style="width: 2%;">No</th>
                <th>Nama Menu</th>
                <th>Parent</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($categories as $index => $category)
                <tr>
                  <td class="text-center" style="width: 2%;">{{ ++$index }}</td>
                  <td>{{ $category->menu_name }}</td>
                  <td>{{ $category->parent->menu_name ?? '' }}</td>
                  <td class="text-center" style="min-width: 65px;">
                    @if ($category->id > 1)
                      <a href="{{ route('admin.treeview.bps.edit', [$category->id]) }}"
                        class="btn btn-icon btn-sm btn-warning m-0"><i class="fas fa-pencil-alt"></i></a>
                      <button data-url="{{ route('admin.treeview.bps.destroy', $category->id) }}"
                        class="btn btn-icon btn-sm btn-danger m-0 btn-delete"><i class="fas fa-trash-alt"></i></button>
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

  <form action="" id="form-delete" method="POST">@csrf @method('DELETE')</form>
@endsection
