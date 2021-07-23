@extends('layouts.admin-master2')

@section('title')
  8 Kelompok Data
@endsection

@section('content')
  <section class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="text-uppercase">Pilih Menu Tree View</h4>
          </div>
          <div class="card-body overflow-auto" id="jstree">
            @include('admin.isiuraian.8keldata.menu-tree')
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  @include('admin.isiuraian.partials.scripts')
  <script>
    $(function() {
      initTreeView(true, '#jstree');
    });
  </script>
@endpush
