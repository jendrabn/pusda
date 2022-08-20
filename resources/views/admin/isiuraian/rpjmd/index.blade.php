@extends('layouts.admin')

@section('title')
  RPJMD
@endsection

@section('content')
  <section class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Pilih Menu Tree View</h4>
          </div>
          <div class="card-body overflow-auto" id="jstree">
            @include('admin.isiuraian.rpjmd.menu_tree')
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/isi-uraian.js') }}"></script>
  <script>
    $(function() {
      initTreeView(true, '#jstree');
    });
  </script>
@endpush
