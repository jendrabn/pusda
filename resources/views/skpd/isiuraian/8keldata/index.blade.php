@extends('layouts.admin-master3')

@section('title')
  8 Kelompok Data
@endsection

@section('content')
  <section class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Pilih Menu Tree View</h4>
      </div>
      <div class="card-body overflow-auto" id="treeview">
        @include('skpd.isiuraian.8keldata.menu_tree')
      </div>
    </div>
  </section>
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/isi-uraian.js') }}"></script>
  <script>
    $(function() {
      initTreeView(true, '#treeview');
    });
  </script>
@endpush
